<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Listeners\DispatchDeliveryJob;
use App\Listeners\SendOrderNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPaid::class => [
            DispatchDeliveryJob::class,
            SendOrderNotifications::class,
        ],
    ];
}
