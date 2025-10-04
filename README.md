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
