<?php

return [
    'driver' => env('DB_DRIVER', 'pdo_sqlite'),

    'connections' => [
        'pdo_sqlite' => [
            'driver' => 'pdo_sqlite',
            'path' => dirname(__DIR__).'/db.sqlite',
        ],
        'pdo_mysql' => [
            'dbname' => env('DB_NAME'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'driver' => 'pdo_mysql'
        ]
    ],
];
