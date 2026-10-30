<?php

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

const MIGRATE_TOKEN = '__MIGRATE_TOKEN__';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! hash_equals(MIGRATE_TOKEN, (string) ($_POST['token'] ?? ''))) {
    http_response_code(404);

    exit;
}

header('Content-Type: text/plain; charset=utf-8');

require __DIR__.'/../yaren/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../yaren/bootstrap/app.php';

$app->usePublicPath(__DIR__);

try {
    $app->make(Kernel::class)->bootstrap();

    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();

    if (($_POST['seed'] ?? '') === '1') {
        Artisan::call('db:seed', ['--force' => true]);
        echo Artisan::output();
    }

    echo 'tables: '.implode(', ', Schema::getTableListing(schemaQualified: false))."\n";
    echo 'products: '.Product::count()."\n";
    echo 'settings: '.Setting::count()."\n";
    echo 'users: '.User::count()."\n";
    echo 'gd_webp: '.(function_exists('imagewebp') ? 'yes' : 'no')."\n";
    echo 'upload_max_filesize: '.ini_get('upload_max_filesize')."\n";
    echo "MIGRATE_OK\n";
} catch (Throwable $exception) {
    http_response_code(500);

    echo get_class($exception).': '.$exception->getMessage()."\n";
}
