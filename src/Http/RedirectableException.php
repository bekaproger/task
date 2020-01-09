<?php

namespace Lil\Http;

class RedirectableException extends \Exception
{
    private $redirectTo;

    public function __construct(string $message, $redirectTo, $status=302)
    {
        parent::__construct($message, $status);

        $this->redirectTo = $redirectTo;
    }

    public function redirectTo()
    {
        return $this->redirectTo;
    }
}
