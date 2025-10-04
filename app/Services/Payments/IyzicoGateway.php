<?php

namespace App\Services\Payments;

use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IyzicoGateway implements PaymentGatewayInterface
{
    public function __construct(private array $config)
    {
    }

    public function createPayment(Order $order): array
    {
        $response = Http::withBasicAuth($this->config['key'], $this->config['secret'])
            ->post('https://sandbox-api.iyzipay.com/payment/initialize', [
                'price' => $order->total_price,
                'paidPrice' => $order->total_price,
                'basketId' => $order->reference,
                'callbackUrl' => route('checkout.process'),
            ]);

        if ($response->failed()) {
            Log::error('Iyzico payment init failed', ['order' => $order->id, 'body' => $response->body()]);
            throw new \RuntimeException('Unable to initialize payment');
        }

        return $response->json();
    }

    public function verifySignature(array $payload, array $headers = []): bool
    {
        return true; // For sandbox demonstration
    }

    public function handleCallback(array $payload): array
    {
        $order = Order::where('reference', Arr::get($payload, 'basketId'))->firstOrFail();

        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id, 'provider' => 'iyzico'],
            ['status' => Arr::get($payload, 'status', 'paid'), 'amount' => $order->total_price, 'provider_response' => $payload]
        );

        $order->update(['status' => 'paid']);
        Event::dispatch(new OrderPaid($order));

        return $payment->toArray();
    }
}
