<?php

namespace App\Http\Validation;

use Lil\Http\AbstractValidator;
use Lil\Http\Request;

class TaskValidator extends AbstractValidator
{
    public function handle(Request $request)
    {
        return [
            'email' => function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            },
            'task' => function ($task) {
                return is_string($task) && (strlen($task) <= 255) && !empty($task);
            },
            'username' => function ($username) {
                return is_string($username) && (strlen($username) <= 255) && !empty($username);
            },
        ];
    }

    public function messages()
    {
        return [
            'email' => 'Email must be valid email',
            'task' => 'Task must be text',
            'username' => 'Username must be string',
        ];
    }
}
