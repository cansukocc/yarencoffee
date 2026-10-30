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

`_design-reference/` içindeki Next.js çıktısı. Görünüm, metinler, renkler ve animasyonlar birebir korunacak.
Bu klasör yalnızca referanstır: içinde hiçbir şey çalıştırılmaz, `npm install` yapılmaz.

## Sunucu kısıtları

- cPanel, SSH yok, PHP 8.3, yalnızca FTP.
- Sunucuda composer, npm ve artisan çalıştırılamaz.
- Kuyruk işçisi ve cron varsayılmaz (`QUEUE_CONNECTION=sync`).
- Laravel çekirdeği `public_html` dışında, `public` içeriği `public_html` içinde.
- FTP kökü hesabın ev dizinidir. Deploy hedefleri yalnızca `/yaren` (Laravel çekirdeği) ve `/public_html` (public içeriği). Diğer klasörlere dokunulmaz, VS Code "Upload Project" kullanılmaz.
- `public_html/.htaccess` içindeki cPanel PHP satırı korunur; Laravel'in `.htaccess` içeriğiyle birleştirilir, üzerine yazılmaz.

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
- Şifreler yalnızca `.env` ve `.vscode/sftp.json` içinde.
- Sunucuya dosya yükleme ve silme yalnızca açıkça istendiğinde.
- Geçici dosyalar adım sonunda silinir.
- Her adım sonunda değişen dosyalar, test sonuçları ve bilinen eksikler raporlanır.
