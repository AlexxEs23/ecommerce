<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway integration.
    | Make sure to set the proper credentials in your .env file.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
