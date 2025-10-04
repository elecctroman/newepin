<?php

namespace App\Services\Payments;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function createPayment(Order $order): array;

    public function verifySignature(array $payload, array $headers = []): bool;

    public function handleCallback(array $payload): array;
}
