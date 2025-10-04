<?php

namespace App\Services;

use App\Jobs\DispatchOrderDeliveryJob;
use App\Models\Order;

class OrderRetryService
{
    public function retry(Order $order): void
    {
        if ($order->status !== 'failed') {
            return;
        }

        DispatchOrderDeliveryJob::dispatch($order);
    }
}
