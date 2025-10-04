<?php

return [
    'shopier' => [
        'key' => env('SHOPIER_API_KEY'),
        'secret' => env('SHOPIER_API_SECRET'),
    ],
    'iyzico' => [
        'key' => env('IYZICO_API_KEY'),
        'secret' => env('IYZICO_SECRET_KEY'),
    ],
    'paytr' => [
        'merchant_id' => env('PAYTR_MERCHANT_ID'),
        'merchant_key' => env('PAYTR_MERCHANT_KEY'),
        'merchant_salt' => env('PAYTR_MERCHANT_SALT'),
    ],
    'turkpin' => [
        'url' => env('TURKPIN_API_URL'),
        'key' => env('TURKPIN_API_KEY'),
    ],
    'pinabi' => [
        'url' => env('PINABI_API_URL'),
        'key' => env('PINABI_API_KEY'),
    ],
    'netgsm' => [
        'usercode' => env('NETGSM_USERCODE'),
        'password' => env('NETGSM_PASSWORD'),
        'sender' => env('NETGSM_SENDER'),
    ],
];
