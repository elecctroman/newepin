<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\Suppliers\SupplierManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class DispatchOrderDeliveryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $backoff = 30;

    public function __construct(public Order $order)
    {
    }

    public function handle(SupplierManager $manager): void
    {
        $manager->dispatch($this->order);
    }

    public function failed(Throwable $exception): void
    {
        \Log::error('Delivery job failed', [
            'order' => $this->order->id,
            'message' => $exception->getMessage(),
        ]);
    }
}
