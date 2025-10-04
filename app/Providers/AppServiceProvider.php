<?php

namespace App\Providers;

use App\Models\Order;
use App\Services\Payments\IyzicoGateway;
use App\Services\Payments\PaytrGateway;
use App\Services\Payments\PaymentGatewayManager;
use App\Services\Payments\ShopierGateway;
use App\Services\Suppliers\PinAbiService;
use App\Services\Suppliers\SupplierManager;
use App\Services\Suppliers\TurkPinService;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ShopierGateway::class, fn () => new ShopierGateway(Config::get('services.shopier')));
        $this->app->singleton(IyzicoGateway::class, fn () => new IyzicoGateway(Config::get('services.iyzico')));
        $this->app->singleton(PaytrGateway::class, fn () => new PaytrGateway(Config::get('services.paytr')));

        $this->app->singleton(SupplierManager::class, function () {
            $manager = new SupplierManager();
            $manager->register('turkpin', new TurkPinService(Config::get('services.turkpin')));
            $manager->register('pinabi', new PinAbiService(Config::get('services.pinabi')));

            return $manager;
        });

        $this->app->singleton(PaymentGatewayManager::class, function ($app) {
            $manager = new PaymentGatewayManager();
            $manager->register('shopier', $app->make(ShopierGateway::class));
            $manager->register('iyzico', $app->make(IyzicoGateway::class));
            $manager->register('paytr', $app->make(PaytrGateway::class));

            return $manager;
        });
    }

    public function boot(): void
    {
        Order::observe(OrderObserver::class);
    }
}
