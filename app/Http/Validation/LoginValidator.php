<?php

namespace App\Http\Validation;

use Lil\Http\AbstractValidator;
use Lil\Http\Request;

class LoginValidator extends AbstractValidator
{
    public function handle(Request $request)
    {
        return [
            'email' => function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            },
            'password' => 'is_string',
        ];
    }

    public function messages()
    {
        return [
            'email' => 'Email parameter must be valid email',
            'password' => 'Password must be string',
        ];
    }
}
