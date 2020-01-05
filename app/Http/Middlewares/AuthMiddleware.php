<?php

namespace App\Http\Middlewares;

use Lil\Http\Request;
use Lil\Authentication\AuthMiddleware as Middleware;

class AuthMiddleware extends Middleware
{
    public function redirectTo(Request $request)
    {
        return '/login';
    }
}
