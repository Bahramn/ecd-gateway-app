<?php

return [
    'default_timeout' => env('DEFAULT_PAYMENT_TIMEOUT', 30),

    'default_gateway' => env('DEFAULT_PAYMENT_GATEWAY', 'ecd'),

    'gateways' => [
        [
            'name' => 'ecd',
            'class' => Bahramn\EcdIpg\Gateways\Ecd\EcdGateway::class,
            'merchant_demo_id' => 'demo',
            'active' => env('ECD_GATEWAY_ACTIVE', false),
            'merchant_id' => env('ECD_MERCHANT_ID', '014722971022001'),
            'terminal_id' => env('ECD_TERMINAL_ID', '97103967'),
            'key'           =>  '105CF93E35108079B635F98D9060D1453096A7F9',
            'callback_url' => '/payment/gateways/ecd/callback',
        ],
    ]
];
