<?php

namespace Lil\Container;

use Psr\Container\ContainerInterface as PsrContainer;

interface ContainerInterface extends PsrContainer
{
    public function set($id, $value): void;
}
