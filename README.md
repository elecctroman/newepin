# NewEpin Platform

Laravel 10 based digital goods platform for selling E-PINs, license keys, and digital accounts.

## Features
- Modular architecture with repository-style service managers
- Wallet balances, orders, product catalog, reviews, and CMS blog
- Payment integrations (Shopier, İyzico, PayTR) with webhook handling
- Supplier integrations (TurkPin, PinAbi) with queue-based delivery
- Admin panel with product, order, and support ticket management
- API for mobile apps and partner integrations

## Getting Started
1. Install dependencies: `composer install` and `npm install`
2. Copy `.env.example` to `.env` and configure database + API keys
3. Generate key: `php artisan key:generate`
4. Run migrations and seeders: `php artisan migrate --seed`
5. Start local server: `php artisan serve`
6. Queue workers: `php artisan queue:work`

Use Laravel Horizon or another queue worker for production deployments.

## Ubuntu 22.04 Sunucular için Otomatik Kurulum

Projeyi bir Ubuntu 22.04 sunucusuna ilk kez kurarken kök dizinde bulunan `setup.sh` betiğini kullanarak tüm sistem bağımlılıklarını ve uygulamayı tek komutla hazırlayabilirsiniz:

```bash
sudo bash setup.sh
```

Betik şu adımları otomatikleştirir:

- PHP 8.2, MySQL, Redis, Node.js 18, Composer, Supervisor ve Nginx kurulumları
- UFW güvenlik duvarının temel yapılandırması
- MySQL veritabanı ve kullanıcı oluşturma (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
- `.env` dosyasının oluşturulması ve temel anahtarların (APP_ENV, APP_URL vb.) güncellenmesi
- `composer install`, `npm install`, `npm run build`, `php artisan migrate --seed`, `php artisan storage:link`
- Supervisor queue worker ve Nginx site yapılandırmasının hazırlanması

İsteğe bağlı olarak ortam değişkenleriyle özel ayarlar belirleyebilirsiniz. Örneğin:

```bash
APP_URL="https://epin.example" \
DB_DATABASE=epinapp \
DB_USERNAME=epinuser \
DB_PASSWORD='gizliSifre123' \
MYSQL_ROOT_PASSWORD='sunucuRootParolasi' \
ENABLE_UFW=false \
sudo bash setup.sh
```

Betik tamamlandıktan sonra site Nginx üzerinden servis edilir ve Supervisor kuyruk işçisi otomatik olarak çalışmaya başlar.
