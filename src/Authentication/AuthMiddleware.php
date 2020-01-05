<?php

namespace Lil\Authentication;

use Lil\Http\AbstractMiddleware;
use Lil\Http\RedirectableException;
use Lil\Http\Request;

class AuthMiddleware extends AbstractMiddleware
{
    protected $auth;

    public function __construct(AuthManagerInterface $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request)
    {
        $user = $this->auth->user();
        if (!$user) {
            throw new RedirectableException('Unauthenticated', $this->redirectTo($request));
        }
    }

    protected function redirectTo(Request $request)
    {
        return '/login';
    }
}
