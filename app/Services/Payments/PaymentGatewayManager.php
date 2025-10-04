<?php

namespace App\Services\Payments;

use App\Models\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class PaymentGatewayManager
{
    /** @var array<string, PaymentGatewayInterface> */
    protected array $gateways = [];

    public function register(string $name, PaymentGatewayInterface $gateway): void
    {
        $this->gateways[$name] = $gateway;
    }

    public function get(string $name): ?PaymentGatewayInterface
    {
        return Arr::get($this->gateways, $name);
    }

    public function create(Order $order, string $method): array
    {
        $gateway = $this->get($method);

        if (! $gateway) {
            Log::error('Payment gateway unavailable', ['method' => $method]);
            throw new \RuntimeException('Gateway not available');
        }

        return $gateway->createPayment($order);
    }
}
