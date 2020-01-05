<?php

namespace App\Http\Middlewares;

use Lil\Authentication\AuthManagerInterface;
use Lil\Http\AbstractMiddleware;
use Lil\Http\Request;

class AdminMiddleware extends AbstractMiddleware
{
    private $auth;

    public function __construct(AuthManagerInterface $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request)
    {
        $user = $this->auth->user();
        if (!($user && $user->getIsAdmin())) {
            throw new \Exception('Forbidden', 403);
        }
    }
}
