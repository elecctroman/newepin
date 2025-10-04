<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function updated(Order $order): void
    {
        Log::info('Order updated', [
            'id' => $order->id,
            'status' => $order->status,
        ]);
    }
}
