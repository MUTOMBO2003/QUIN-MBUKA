<?php

return [
    'api_key' => env('CINETPAY_API_KEY'),
    'site_id' => env('CINETPAY_SITE_ID'),
    'notify_url' => env('CINETPAY_NOTIFY_URL'),
    'mode' => env('CINETPAY_MODE', 'TEST'),
];