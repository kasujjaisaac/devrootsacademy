<?php

return [
    'environment' => env('PESAPAL_ENV', 'sandbox'),
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),
    'callback_url' => env('PESAPAL_CALLBACK_URL'),
    'ipn_url' => env('PESAPAL_IPN_URL'),
    'ipn_method' => env('PESAPAL_IPN_METHOD', 'GET'),
    'currency' => env('PESAPAL_CURRENCY', 'UGX'),
    'branch' => env('PESAPAL_BRANCH', 'DevRoots Academy'),
    'country_code' => env('PESAPAL_COUNTRY_CODE', 'UG'),
    'timeout' => (int) env('PESAPAL_TIMEOUT', 30),
    'base_urls' => [
        'sandbox' => 'https://cybqa.pesapal.com/pesapalv3',
        'live' => 'https://pay.pesapal.com/v3',
    ],
];
