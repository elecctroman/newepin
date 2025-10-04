<?php

namespace App\Services\Suppliers;

use App\Models\Order;
use App\Models\Product;

interface SupplierInterface
{
    public function isEnabled(): bool;

    public function fetchProducts(): array;

    public function createOrder(Order $order): array;

    public function fetchDelivery(string $remoteId): array;
}
