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
            'password' => function ($pass) {
                return is_string($pass) && (strlen($pass) <= 255) && !empty($pass);
            },
            'name' => function ($val) {
                return is_string($val) && (strlen($val) <= 255) && !empty($val);
            },
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
