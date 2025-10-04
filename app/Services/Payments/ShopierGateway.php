<?php

namespace App\Services\Payments;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class ShopierGateway implements PaymentGatewayInterface
{
    public function __construct(private array $config)
    {
    }

    public function createPayment(Order $order): array
    {
        return [
            'redirect_url' => 'https://www.shopier.com/checkout/'.$order->reference,
            'fields' => [
                'API_KEY' => $this->config['key'],
                'signature' => hash_hmac('sha256', $order->reference, $this->config['secret'] ?? ''),
            ],
        ];
    }

    public function verifySignature(array $payload, array $headers = []): bool
    {
        $signature = Arr::get($payload, 'signature');
        $expected = hash_hmac('sha256', Arr::get($payload, 'order_ref'), $this->config['secret'] ?? '');

        return hash_equals($expected, (string) $signature);
    }

    public function handleCallback(array $payload): array
    {
        if (! $this->verifySignature($payload)) {
            Log::warning('Shopier signature mismatch', ['payload' => $payload]);
            throw new \RuntimeException('Invalid signature');
        }

        $order = Order::where('reference', Arr::get($payload, 'order_ref'))->firstOrFail();

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id, 'provider' => 'shopier'],
            ['status' => 'paid', 'amount' => $order->total_price, 'provider_response' => $payload]
        );

        $order->update(['status' => 'paid']);

        Event::dispatch(new OrderPaid($order));

        return $payment->toArray();
    }
}
