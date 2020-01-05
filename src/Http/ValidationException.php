<?php

namespace Lil\Http;

class ValidationException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message, 406);
    }
}
