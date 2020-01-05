<?php

namespace Lil\Http;

class RedirectableException extends \Exception
{
    private $redirectTo;

    public function __construct(string $message = '', $redirectTo)
    {
        parent::__construct($message);

        $this->redirectTo = $redirectTo;
    }

    public function redirectTo()
    {
        return $this->redirectTo;
    }
}
