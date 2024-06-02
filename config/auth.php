<?php

return [
    'defaults' => [
        'guard' => 'api', // DEFAULT AUTHENTICATION GUARD
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'sanctum', 
            'provider' => 'users' 
        ]
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
    'password_timeout' => 10800,

];
