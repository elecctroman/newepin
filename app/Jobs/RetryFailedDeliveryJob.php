<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\OrderRetryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetryFailedDeliveryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private int $orderId)
    {
    }

    public function handle(OrderRetryService $service): void
    {
        $order = Order::find($this->orderId);

        if ($order) {
            $service->retry($order);
        }
    }
}
