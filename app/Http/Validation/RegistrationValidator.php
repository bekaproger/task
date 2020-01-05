<?php

namespace App\Http\Validation;

use Lil\Http\AbstractValidator;
use Lil\Http\Request;

class RegistrationValidator extends AbstractValidator
{
    public function handle(Request $request)
    {
        return [
            'email' => function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            },
            'password' => 'is_string',
            'name' => 'is_string',
        ];
    }

    public function messages()
    {
        return [
            'email' => 'Email should be valid email',
            'password' => 'Password should be string',
            'name' => 'Name should be string',
        ];
    }
}
