# Yâren

## Proje özeti

Yâren kahve markası için tek sayfalık site ve yönetim paneli. İş başvurusu case study'si.
Değerlendirme ölçütleri: görsel özen, mobil uyum, çalışan etkileşimler, kod okunabilirliği.

Kapsam ve yol haritası: `docs/PROJECT_SCOPE.md`, `docs/ROADMAP.md`.

## Stack

- Laravel, Blade, Tailwind CSS v4, Vite, vanilla JS (ES modülleri), animasyon için GSAP.
- Lokalde SQLite, canlıda MySQL.
- Filament, Livewire veya React KULLANILMAYACAK. Admin paneli sade Blade ile yazılacak.

## Tasarım kaynağı

Tasarımın tek kaynağı mevcut koddur (`resources/views`, `resources/css/app.css`). Görünüm, metinler, renkler ve animasyonlar korunur.

## Sunucu kısıtları

- cPanel, SSH yok, PHP 8.3, yalnızca FTP.
- Sunucuda composer, npm ve artisan çalıştırılamaz.
- Kuyruk işçisi ve cron varsayılmaz (`QUEUE_CONNECTION=sync`).
- Laravel çekirdeği `public_html` dışında, `public` içeriği `public_html` içinde.
- FTP kökü hesabın ev dizinidir. Deploy hedefleri yalnızca `/yaren` (Laravel çekirdeği) ve `/public_html` (public içeriği). Diğer klasörlere dokunulmaz, VS Code "Upload Project" kullanılmaz.
- `public_html/.htaccess` içindeki cPanel PHP satırı korunur; Laravel'in `.htaccess` içeriğiyle birleştirilir, üzerine yazılmaz.
- Admin yüklemeleri `public_path('uploads')` altına gider, çünkü sunucuda symlink yok.

## Deploy

- `npm run deploy`: commit'li son sürümü derler, yalnızca değişen dosyaları yükler.
- `npm run deploy -- --dry-run`: yüklenecek ve silinecek dosyaları listeler, sunucuya yazmaz.
- `npm run deploy -- --env`: `.env.production` dosyasını `/yaren/.env` olarak da yükler.
- `npm run deploy -- --htaccess`: `deploy/htaccess.production` dosyasını `/public_html/.htaccess` olarak da yükler.
- `npm run deploy -- --migrate`: çekirdek yüklendikten sonra sunucuda `migrate --force` çalıştırır.
- `npm run deploy -- --seed`: `--migrate` işlemine ek olarak `db:seed --force` çalıştırır. Seeder'lar mevcut veriyi ezmez.
- `--env` yüklemesi migrate'ten önce yapılır, böylece seeder'lar güncel ayarları görür.

## Yönetim paneli

- Adres: `/yonetim`. Kayıt ve şifre sıfırlama yoktur.
- Admin kullanıcısı `AdminUserSeeder` ile `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD` değerlerinden oluşur (`php artisan db:seed` veya `--seed`). Var olan kullanıcının şifresi değişmez.
- Yüklenen görseller `public/uploads/products` altına WebP olarak kaydedilir ve git dışındadır.
- SEO başlığı ve açıklaması Site Ayarları'ndan yönetilir (`meta_title`, `meta_description`). JSON-LD `App\Support\StructuredData` ile üretilir.

## Lokal ortam

- macOS 14.5. Homebrew ile kurulum yapılmaz (kaynaktan derliyor).
- Node nvm ile yönetilir (`.nvmrc`: 22).
- Görsel optimizasyonu npm `sharp` ile, FTP deploy Node scripti ile yapılır.

## Kod kuralları

- Küçük ve okunabilir Blade bileşenleri.
- İnce controller, doğrulama için Form Request.
- Tekrar eden kod yok, gereksiz yorum yok, gereksiz paket yok.

## Çalışma kuralları

- Her adım tek commit (Conventional Commits, İngilizce) ve push.
- Şifreler yalnızca `.env`, `.env.production`, `.env.deploy` ve `.vscode/sftp.json` içinde.
- Sunucuya dosya yükleme ve silme yalnızca açıkça istendiğinde.
- Geçici dosyalar adım sonunda silinir.
- Her adım sonunda değişen dosyalar, test sonuçları ve bilinen eksikler raporlanır.
