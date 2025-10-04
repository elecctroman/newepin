<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PaymentWebhookController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\SupportTicketController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/orders', [ProductApiController::class, 'store']);
    Route::get('/orders/{order}', [ProductApiController::class, 'show']);
    Route::get('/wallet/transactions', [AuthController::class, 'transactions']);
    Route::apiResource('tickets', SupportTicketController::class)->only(['index', 'store', 'show']);
    Route::post('/tickets/{ticket}/reply', [SupportTicketController::class, 'reply']);
});

Route::post('/webhooks/shopier', [PaymentWebhookController::class, 'shopier'])->name('api.webhooks.shopier');
Route::post('/webhooks/iyzico', [PaymentWebhookController::class, 'iyzico'])->name('api.webhooks.iyzico');
Route::post('/webhooks/paytr', [PaymentWebhookController::class, 'paytr'])->name('api.webhooks.paytr');
