<?php

return [
    'driver' => env('DB_DRIVER', 'pdo_sqlite'),

    'connections' => [
        'pdo_sqlite' => [
            'driver' => 'pdo_sqlite',
            'path' => dirname(__DIR__).'/db.sqlite',
        ],
    ],
];
