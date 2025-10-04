<?php

namespace App\Services\Suppliers;

use App\Models\Order;
use App\Notifications\OrderDeliveredNotification;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SupplierManager
{
    /** @var array<string, SupplierInterface> */
    protected array $suppliers = [];

    public function register(string $name, SupplierInterface $supplier): void
    {
        $this->suppliers[$name] = $supplier;
    }

    public function get(string $name): ?SupplierInterface
    {
        return Arr::get($this->suppliers, $name);
    }

    public function dispatch(Order $order): void
    {
        $supplier = $this->get($order->product->supplier);

        if (! $supplier || ! $supplier->isEnabled()) {
            Log::warning('Supplier unavailable for order', ['order_id' => $order->id]);
            return;
        }

        $response = $supplier->createOrder($order);

        $order->update([
            'status' => $response['status'] ?? 'processing',
            'supplier_response' => $response,
        ]);

        if (($response['status'] ?? null) === 'delivered') {
            $order->user->notify(new OrderDeliveredNotification($order));
        }
    }
}
