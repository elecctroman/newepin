<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Payments\IyzicoGateway;
use App\Services\Payments\PaytrGateway;
use App\Services\Payments\ShopierGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function __construct(
        private ShopierGateway $shopier,
        private IyzicoGateway $iyzico,
        private PaytrGateway $paytr,
    ) {
    }

    public function shopier(Request $request): JsonResponse
    {
        $payload = $request->all();
        $this->shopier->handleCallback($payload);

        return response()->json(['status' => 'ok']);
    }

    public function iyzico(Request $request): JsonResponse
    {
        $payload = $request->all();
        $this->iyzico->handleCallback($payload);

        return response()->json(['status' => 'ok']);
    }

    public function paytr(Request $request): JsonResponse
    {
        $payload = $request->all();
        $this->paytr->handleCallback($payload);

        return response()->json(['status' => 'ok']);
    }
}
