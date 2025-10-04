<?php

namespace App\Services\Suppliers;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurkPinService implements SupplierInterface
{
    public function __construct(private array $config)
    {
    }

    public function isEnabled(): bool
    {
        return ! empty($this->config['key']);
    }

    public function fetchProducts(): array
    {
        return Http::withToken($this->config['key'])
            ->get($this->config['url'].'/products')
            ->json('data', []);
    }

    public function createOrder(Order $order): array
    {
        $response = Http::withToken($this->config['key'])->post($this->config['url'].'/orders', [
            'product_id' => $order->product->api_product_id,
            'quantity' => $order->quantity,
            'reference' => $order->reference,
        ]);

        if ($response->failed()) {
            Log::error('TurkPin order failed', ['order_id' => $order->id, 'body' => $response->body()]);
            throw new \RuntimeException('TurkPin order failed');
        }

        return $response->json();
    }

    public function fetchDelivery(string $remoteId): array
    {
        return Http::withToken($this->config['key'])
            ->get($this->config['url'].'/orders/'.$remoteId)
            ->json();
    }
}
