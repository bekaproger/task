<?php

return [
    'auth' => \App\Http\Middlewares\AuthMiddleware::class,
    'admin' => \App\Http\Middlewares\AdminMiddleware::class,
    'guest' => \App\Http\Middlewares\GuestMiddleware::class
];