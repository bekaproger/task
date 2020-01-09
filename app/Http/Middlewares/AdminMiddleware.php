<?php

namespace App\Http\Middlewares;

use App\Model\User;
use Lil\Http\RedirectableException;
use Lil\Http\Request;
use Lil\Authentication\AuthMiddleware;

class AdminMiddleware extends AuthMiddleware
{
    public function handle(Request $request)
    {
        /**
         * @var $user User
         */
        $user = $this->auth->user();
        if (!($user && $user->getIsAdmin())) {
            throw new RedirectableException('Unauthorized', $this->redirectTo($request));
        }
    }

    public function redirectTo(Request $request)
    {
        return $request->getSession()->getPreviousUrl();
    }
}
