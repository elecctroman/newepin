<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Notifications\OrderProcessingNotification;

class SendOrderNotifications
{
    public function handle(OrderPaid $event): void
    {
        $event->order->user->notify(new OrderProcessingNotification($event->order));
    }
}
