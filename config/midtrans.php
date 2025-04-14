<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and configurations for Midtrans.
    | Put your configuration here instead of hardcoding it in the code.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'sanitize' => env('MIDTRANS_SANITIZE', true),
    '3ds' => env('MIDTRANS_3DS', true),
    'append_notif_url' => env('MIDTRANS_APPEND_NOTIF_URL', ''),

    // Payment Types Enabled
    'enabled_payments' => [
        'credit_card', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 
        'permata_va', 'shopeepay', 'gopay', 'indomaret', 
        'alfamart', 'akulaku'
    ],

    // Set your Snap redirect URL here
    'finish_redirect_url' => env('MIDTRANS_FINISH_URL', '/'),
    'unfinish_redirect_url' => env('MIDTRANS_UNFINISH_URL', '/'),
    'error_redirect_url' => env('MIDTRANS_ERROR_URL', '/'),
    
    // Set default currency
    'currency' => 'IDR',
    
    // Customize expiry time (in minutes)
    'expiry' => [
        'unit' => 'minutes', 
        'duration' => 1440, // 24 hours
    ],
];