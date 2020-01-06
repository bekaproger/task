<?php

namespace Lil\Session;

use Lil\Http\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as SymfonySessionInterface;

interface SessionInterface extends SymfonySessionInterface
{
    public function set(string $name, $value, int $lifetime = null);

    public function setPreviousUrl(Request $request): void;

    public function getPreviousUrl(): string;
}
