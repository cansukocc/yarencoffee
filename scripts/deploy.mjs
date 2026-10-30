import { execSync } from 'node:child_process';
import { createHash } from 'node:crypto';
import { mkdtemp, readFile, readdir, rm, stat } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { dirname, join, relative, resolve } from 'node:path';
import { Readable, Writable } from 'node:stream';
import { fileURLToPath, pathToFileURL } from 'node:url';
import { Client } from 'basic-ftp';

const ROOT = resolve(dirname(fileURLToPath(import.meta.url)), '..');

const CORE_ROOT = '/yaren';
const PUBLIC_ROOT = '/public_html';
const MANIFEST_PATH = `${CORE_ROOT}/.deploy-manifest.json`;
const INDEX_PATH = `${PUBLIC_ROOT}/index.php`;

const CONNECTIONS = 2;
const BATCH_SIZE = 200;
const MAX_ATTEMPTS = 3;
const FTP_TIMEOUT = 60_000;

const CORE_SOURCES = [
    'app',
    'bootstrap',
    'config',
    'database',
    'resources/views',
    'routes',
    'vendor',
    'artisan',
    'composer.json',
    'composer.lock',
];

const WRITABLE_DIRS = [
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'storage/app/public',
    'bootstrap/cache',
];

const PROTECTED_SEGMENTS = new Set(['..', '.htaccess', '.well-known', 'storage', 'uploads']);

export function isProtected(remotePath) {
    const segments = remotePath.split('/');
    const insideDeployRoots = remotePath.startsWith(`${CORE_ROOT}/`) || remotePath.startsWith(`${PUBLIC_ROOT}/`);

    return (
        !insideDeployRoots ||
        remotePath === MANIFEST_PATH ||
        segments.some((segment) => segment.startsWith('.env') || PROTECTED_SEGMENTS.has(segment))
    );
}

export function planChanges(remoteManifest, files) {
    const localPaths = new Set(files.map((file) => file.remote));
    const stalePaths = Object.keys(remoteManifest).filter((path) => !localPaths.has(path));

    return {
        uploads: files.filter((file) => remoteManifest[file.remote] !== file.hash),
        deletions: stalePaths.filter((path) => !isProtected(path)),
        keptStale: stalePaths.filter(isProtected),
    };
}

function isExcluded(path) {
    const name = path.split('/').pop();

    return (
        /\.md$/i.test(name) ||
        name.startsWith('.git') ||
        name.startsWith('.env') ||
        path.startsWith('bootstrap/cache/') ||
        /^database\/.*\.sqlite/.test(path)
    );
}

async function walk(path) {
    const info = await stat(path);

    if (info.isFile()) {
        return [path];
    }

    const entries = await readdir(path, { withFileTypes: true });
    const nested = await Promise.all(
        entries
            .filter((entry) => entry.isFile() || entry.isDirectory())
            .map((entry) => walk(join(path, entry.name))),
    );

    return nested.flat();
}

async function describeFile(local, remote) {
    const content = await readFile(local);

    return { local, remote, hash: createHash('sha256').update(content).digest('hex'), size: content.length };
}

async function collectCoreFiles(buildDir) {
    const paths = (await Promise.all(CORE_SOURCES.map((source) => walk(join(buildDir, source))))).flat();
    const files = paths
        .map((local) => ({ local, path: relative(buildDir, local) }))
        .filter(({ path }) => !isExcluded(path));

    return Promise.all(files.map(({ local, path }) => describeFile(local, `${CORE_ROOT}/${path}`)));
}

async function collectPublicFiles(buildDir) {
    const publicDir = join(buildDir, 'public');
    const files = (await walk(publicDir))
        .map((local) => ({ local, path: relative(publicDir, local) }))
        .filter(({ path }) => path !== 'index.php' && path !== '.htaccess' && !isExcluded(path));

    return Promise.all(files.map(({ local, path }) => describeFile(local, `${PUBLIC_ROOT}/${path}`)));
}

async function collectRelease(buildDir) {
    const core = await collectCoreFiles(buildDir);
    const publicFiles = await collectPublicFiles(buildDir);
    const index = await describeFile(join(buildDir, 'deploy/index.production.php'), INDEX_PATH);

    return [...core, ...publicFiles, index];
}

function run(command, cwd) {
    execSync(command, { cwd, stdio: ['ignore', 'ignore', 'inherit'] });
}

function assertCleanTree() {
    const status = execSync('git status --porcelain', { cwd: ROOT, encoding: 'utf8' });

    if (status.trim() !== '') {
        throw new Error(`Çalışma ağacı temiz değil:\n${status}`);
    }
}

async function buildRelease() {
    const buildDir = await mkdtemp(join(tmpdir(), 'yaren-deploy-'));

    console.log('Sürüm hazırlanıyor...');
    run(`git archive --format=tar HEAD | tar -x -C "${buildDir}"`, ROOT);
    run('composer install --no-dev --optimize-autoloader --no-interaction --quiet', buildDir);
    run('npm ci --silent', buildDir);
    run('npm run build --silent', buildDir);

    return buildDir;
}

async function readDeployEnv() {
    const content = await readFile(join(ROOT, '.env.deploy'), 'utf8');
    const pairs = content
        .split('\n')
        .filter((line) => line.includes('='))
        .map((line) => {
            const separator = line.indexOf('=');

            return [line.slice(0, separator).trim(), line.slice(separator + 1).trim().replace(/^"(.*)"$/, '$1')];
        });

    return Object.fromEntries(pairs);
}

async function connect(env) {
    const client = new Client(FTP_TIMEOUT);

    await client.access({
        host: env.FTP_HOST,
        port: Number(env.FTP_PORT),
        user: env.FTP_USER,
        password: env.FTP_PASSWORD,
        secure: env.FTP_SECURE === 'true',
        secureOptions: { rejectUnauthorized: false },
    });

    return client;
}

async function remoteFileExists(client, path) {
    try {
        await client.size(path);

        return true;
    } catch (error) {
        if (error.code === 550) {
            return false;
        }
        throw error;
    }
}

async function readRemoteManifest(client) {
    if (!(await remoteFileExists(client, MANIFEST_PATH))) {
        return {};
    }

    const chunks = [];
    const sink = new Writable({
        write(chunk, _encoding, done) {
            chunks.push(chunk);
            done();
        },
    });

    await client.downloadTo(sink, MANIFEST_PATH);

    return JSON.parse(Buffer.concat(chunks).toString('utf8'));
}

async function writeRemoteManifest(client, manifest) {
    const temporaryPath = `${MANIFEST_PATH}.tmp`;

    await client.uploadFrom(Readable.from(Buffer.from(JSON.stringify(manifest))), temporaryPath);
    await client.remove(MANIFEST_PATH, true);
    await client.rename(temporaryPath, MANIFEST_PATH);
}

function createUploader(env, slots) {
    const knownDirs = new Set();

    const sendFile = async (slot, file) => {
        if (slot.client.closed) {
            slot.client = await connect(env);
        }

        const directory = dirname(file.remote);

        if (!knownDirs.has(directory)) {
            await slot.client.ensureDir(directory);
            knownDirs.add(directory);
        }

        await slot.client.uploadFrom(file.local, file.remote);
    };

    const sendWithRetry = async (slot, file) => {
        for (let attempt = 1; ; attempt += 1) {
            try {
                return await sendFile(slot, file);
            } catch (error) {
                slot.client.close();

                if (attempt === MAX_ATTEMPTS) {
                    throw new Error(`${file.remote}: ${error.message}`);
                }

                console.warn(`Tekrar deneniyor (${attempt}/${MAX_ATTEMPTS}): ${file.remote}: ${error.message}`);
                await new Promise((done) => setTimeout(done, attempt * 1000));
            }
        }
    };

    return async function sendFiles(files, onUploaded) {
        const queue = [...files];

        const worker = async (slot) => {
            while (queue.length > 0) {
                const file = queue.shift();

                await sendWithRetry(slot, file);
                onUploaded(file);
            }
        };

        const results = await Promise.allSettled(slots.map(worker));
        const failure = results.find((result) => result.status === 'rejected');

        if (failure) {
            throw failure.reason;
        }
    };
}

function chunk(items, size) {
    const chunks = [];

    for (let start = 0; start < items.length; start += size) {
        chunks.push(items.slice(start, start + size));
    }

    return chunks;
}

async function uploadRelease(uploads, manifest, slots, sendFiles) {
    const total = uploads.length;
    let uploaded = 0;

    const track = (file) => {
        manifest[file.remote] = file.hash;
        uploaded += 1;

        if (uploaded % 25 === 0 || uploaded === total) {
            console.log(`[${uploaded}/${total}] ${file.remote}`);
        }
    };

    for (const batch of chunk(uploads, BATCH_SIZE)) {
        try {
            await sendFiles(batch, track);
        } finally {
            await writeRemoteManifest(await ensureConnected(slots[0]), manifest);
        }
    }
}

async function ensureConnected(slot) {
    if (slot.client.closed) {
        slot.client = await connect(slot.env);
    }

    return slot.client;
}

async function ensureWritableDirs(client) {
    for (const directory of WRITABLE_DIRS) {
        await client.ensureDir(`${CORE_ROOT}/${directory}`);
    }
}

async function deleteStaleFiles(client, deletions, manifest) {
    for (const path of deletions) {
        await client.remove(path, true);
        delete manifest[path];
    }
}

function printPlan({ uploads, deletions, keptStale }) {
    const bytes = uploads.reduce((sum, file) => sum + file.size, 0);

    console.log(`Yüklenecek: ${uploads.length} dosya (${(bytes / 1048576).toFixed(1)} MB)`);
    console.log(`Silinecek: ${deletions.length} dosya`);
    deletions.forEach((path) => console.log(`  - ${path}`));

    if (keptStale.length > 0) {
        console.log(`Korunan eski dosya: ${keptStale.length}`);
    }
}

function splitIndex(uploads) {
    return {
        files: uploads.filter((file) => file.remote !== INDEX_PATH),
        index: uploads.filter((file) => file.remote === INDEX_PATH),
    };
}

async function configFiles(flags) {
    const files = [];

    if (flags.env) {
        files.push(await describeFile(join(ROOT, '.env.production'), `${CORE_ROOT}/.env`));
    }

    if (flags.htaccess) {
        files.push(await describeFile(join(ROOT, 'deploy/htaccess.production'), `${PUBLIC_ROOT}/.htaccess`));
    }

    return files;
}

async function publish(release, plan, remoteManifest, flags, env, slots) {
    const startedAt = Date.now();
    const manifest = { ...remoteManifest };
    const sendFiles = createUploader(env, slots);
    const { files, index } = splitIndex(plan.uploads);

    await ensureWritableDirs(slots[0].client);
    await uploadRelease(files, manifest, slots, sendFiles);
    await sendFiles(await configFiles(flags), (file) => console.log(`Yapılandırma yüklendi: ${file.remote}`));
    await uploadRelease(index, manifest, slots, sendFiles);

    const client = await ensureConnected(slots[0]);

    await deleteStaleFiles(client, plan.deletions, manifest);
    await writeRemoteManifest(client, Object.fromEntries(release.map((file) => [file.remote, file.hash])));

    console.log(`Tamamlandı: ${((Date.now() - startedAt) / 1000).toFixed(0)} sn`);
}

async function openSlots(env) {
    const slots = [];

    while (slots.length < CONNECTIONS) {
        slots.push({ client: await connect(env), env });
    }

    return slots;
}

async function main() {
    const args = new Set(process.argv.slice(2));
    const flags = { dryRun: args.has('--dry-run'), env: args.has('--env'), htaccess: args.has('--htaccess') };

    if (!flags.dryRun) {
        assertCleanTree();
    }

    const env = await readDeployEnv();
    const buildDir = await buildRelease();

    try {
        const release = await collectRelease(buildDir);
        const slots = await openSlots(env);

        try {
            const remoteManifest = await readRemoteManifest(slots[0].client);
            const plan = planChanges(remoteManifest, release);

            printPlan(plan);

            if (!flags.dryRun) {
                await publish(release, plan, remoteManifest, flags, env, slots);
            }
        } finally {
            slots.forEach((slot) => slot.client.close());
        }
    } finally {
        await rm(buildDir, { recursive: true, force: true });
    }
}

if (process.argv[1] && import.meta.url === pathToFileURL(process.argv[1]).href) {
    main().catch((error) => {
        console.error(`Deploy başarısız: ${error.message}`);
        process.exit(1);
    });
}
