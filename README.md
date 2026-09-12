# NSFWhen.com — Film Content Advisory & Timestamp Platform

Mainstream filmlerdeki cinsel içerikleri (seks sahneleri, çıplaklık ve imalı sahneler) topluluk ve editör onaylı şekilde dakika/saniye bazında zaman damgalarıyla işaretleyen web platformu.

> **Önemli Kural:** Sitede hiçbir pornografik/cinsel görsel veya video içeriği bulunmaz. Yalnızca TMDb posterleri/metadata ve topluluk tarafından girilen başlangıç-bitiş zaman damgaları ile kategoriler yer alır.

---

## Teknoloji Mimarisi

- **Backend:** Laravel 11 / 12
- **Frontend:** Vue.js 3 — non-SFC, `createApp` mimarisi (Blade içine gömülü reaktif bileşenler)
- **Veritabanı:** MySQL (hem local hem de Hostinger shared hosting production ortamında)
- **Kuyruk (Queue):** `database` driver. Redis kullanılmaz.
- **Scheduler / Cron:** `routes/console.php` üzerinde `Schedule::command('queue:work --stop-when-empty --max-time=50')->everyMinute()->withoutOverlapping()`
- **Önbellek & Oturum:** `database` driver (`CACHE_STORE=database`, `SESSION_DRIVER=database`)
- **Dış Servis:** TMDb API v3 (Rate limit korumalı, kuyruk job'larıyla senkronize)
- **Lokal Geliştirme:** Laravel Sail (Docker + MySQL 8.4)
- **Lokalizasyon:** Native Laravel i18n (TR ve EN tam destek)

---

## Kurulum ve Lokal Geliştirme

### 1. Depoyu Klonlayın ve Bağımlılıkları Yükleyin
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Laravel Sail (Docker) ile Başlatma
Sail konfigürasyonu (`compose.yaml`) MySQL servisiyle hazır durumdadır:
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```

*(Docker kullanmadan lokalde doğrudan çalıştırmak isterseniz `.env` içinde MySQL bağlantı bilgilerinizi girip `php artisan migrate --seed` ve `php artisan serve` çalıştırabilirsiniz).*

---

## Test Kullanıcı Hesapları (Seeded)

| Rol | E-posta | Parola | İtibar Puanı |
|---|---|---|---|
| **Editör / Admin** | `editor@nsfwhen.com` | `password` | 3,500 |
| **Güvenilir Üye** | `kerem_a@example.com` | `password` | 2,410 |
| **Topluluk Üyesi** | `mira_k@example.com` | `password` | 1,250 |
| **Topluluk Üyesi** | `deniz_y@example.com` | `password` | 820 |
| **Topluluk Üyesi** | `onur_t@example.com` | `password` | 450 |

---

## Hostinger Shared Hosting (Production) Deployment

Hostinger Premium Shared Hosting ortamında persistent daemon (`queue:work` arka plan servis olarak) çalıştırılamadığı için sistem veritabanı kuyruğu ve dakika başı çalışan scheduler mimarisine göre yapılandırılmıştır.

### 1. `.env` Ayarları
Production `.env` dosyanızda şu satırların bulunduğundan emin olun:
```ini
APP_NAME=NSFWhen
APP_ENV=production
APP_DEBUG=false
APP_URL=https://nsfwhen.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u123456789_nsfwhen
DB_USERNAME=u123456789_admin
DB_PASSWORD=guclu_veritabani_sifreniz

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

TMDB_API_KEY=sizin_tmdb_api_anahtariniz
TMDB_READ_TOKEN=sizin_tmdb_read_token
```

### 2. Migration & Seeder Çalıştırma
SSH üzerinden veya hPanel terminalinden:
```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Cron Job Kurulumu (hPanel / cPanel)
hPanel'de **Gelişmiş -> Cron Jobs** bölümüne gidin ve şu görevi her dakika (`* * * * *`) çalışacak şekilde ekleyin:
```bash
* * * * * cd /home/u123456789/domains/nsfwhen.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```
Bu cron job, `routes/console.php` içindeki:
```php
Schedule::command('queue:work --stop-when-empty --max-time=50')->everyMinute()->withoutOverlapping();
```
komutunu tetikleyerek bekleyen TMDb senkronizasyonlarını ve kuyruk görevlerini 50 saniyelik güvenli süre içinde işler ve sonlanır.

---

## TMDb Kullanım ve Telif Bildirimi

Bu ürün TMDb API kullanmaktadır ancak TMDb tarafından onaylanmamış veya tasdik edilmemiştir. Sitede yer alan film posterleri ve metaveriler TMDb API üzerinden sağlanmaktadır. Sitede pornografik hiçbir görsel, klip veya video depolanmaz veya sunulmaz.

---

## Testlerin Çalıştırılması

```bash
php artisan test
```
Tüm feature ve render testleri (`SceneSubmissionTest`, `VotingAndReputationTest`, `AutoDelistCandidateTest`, `EditorAccessTest`, `LocalizationTest`, `PageRenderTest`) in-memory SQLite üzerinde saniyeler içinde çalışır.
