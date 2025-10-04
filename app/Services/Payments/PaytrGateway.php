<?php

namespace App\Services\Payments;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class PaytrGateway implements PaymentGatewayInterface
{
    public function __construct(private array $config)
    {
    }

    public function createPayment(Order $order): array
    {
        $hashStr = $this->config['merchant_id'].$order->user->email.$order->total_price.$this->config['merchant_salt'];
        $token = base64_encode(hash_hmac('sha256', $hashStr, $this->config['merchant_key'], true));

        return [
            'redirect_url' => 'https://www.paytr.com/odeme/guvenli/'.$order->reference,
            'fields' => [
                'merchant_id' => $this->config['merchant_id'],
                'token' => $token,
            ],
        ];
    }

    public function verifySignature(array $payload, array $headers = []): bool
    {
        $expected = base64_encode(hash_hmac('sha256', Arr::get($payload, 'merchant_oid').$this->config['merchant_salt'], $this->config['merchant_key'], true));

        return hash_equals($expected, Arr::get($payload, 'hash'));
    }

    public function handleCallback(array $payload): array
    {
        if (! $this->verifySignature($payload)) {
            Log::warning('PayTR signature mismatch', ['payload' => $payload]);
            throw new \RuntimeException('Invalid signature');
        }

        $order = Order::where('reference', Arr::get($payload, 'merchant_oid'))->firstOrFail();

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id, 'provider' => 'paytr'],
            ['status' => Arr::get($payload, 'status', 'paid'), 'amount' => $order->total_price, 'provider_response' => $payload]
        );

        $order->update(['status' => 'paid']);
        Event::dispatch(new OrderPaid($order));

        return $payment->toArray();
    }
}
