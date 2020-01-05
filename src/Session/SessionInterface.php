<?php

namespace Lil\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface as SymfonySessionInterface;

interface SessionInterface extends SymfonySessionInterface
{
    public function set(string $name, $value, int $lifetime = null);
}
