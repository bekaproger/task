<?php

namespace App\Http\Middlewares;

use Lil\Http\AbstractMiddleware;
use Lil\Http\RedirectableException;
use Lil\Http\Request;

class GuestMiddleware extends AbstractMiddleware
{
    public function handle(Request $request)
    {
        if (auth()->user()) {
            throw new RedirectableException('Already logged', '/');
        }
    }
}
