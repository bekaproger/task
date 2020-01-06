<?php

namespace Lil\Router\Interfaces;

interface RouteInterface
{
    public function middleware($middlewares): self;

    public function where(array $constraints): self;

    public function name(string $name): self;

    public function getName(): ?string;

    public function getHandler();
}
