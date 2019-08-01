<?php
return [
    /*
    |--------------------------------------------------------------------------
    | The default SMS Driver
    |--------------------------------------------------------------------------
    |
    | The default sms driver to use as a fallback when no driver is specified
    | while using the SMS.
    |
    | Supported: "nexmo", "log", "null"
    |
    */
    'default' => env('SMS_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Nexmo Driver Configuration
    |--------------------------------------------------------------------------
    |
    | We specify key, secret, and the number messages will be sent from.
    |
    */
    'nexmo' => [
        'key' => env('NEXMO_KEY', ''),
        'secret' => env('NEXMO_SECRET', ''),
        'from' => env('NEXMO_SMS_FROM', '')
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | If you are using the "log" driver, you may specify the logging channel
    | if you prefer to keep mail messages separate from other log entries
    | for simpler reading. Otherwise, the default channel will be used.
    |
    */
    'log_channel' => env('SMS_LOG_CHANNEL'),
];