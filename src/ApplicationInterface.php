<?php

namespace Lil;

use Lil\Container\ContainerInterface;

interface ApplicationInterface extends ContainerInterface
{
    public function getBaseDir(): string;
}
