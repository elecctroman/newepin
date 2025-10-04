<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Jobs\DispatchOrderDeliveryJob;

class DispatchDeliveryJob
{
    public function handle(OrderPaid $event): void
    {
        DispatchOrderDeliveryJob::dispatch($event->order);
    }
}
