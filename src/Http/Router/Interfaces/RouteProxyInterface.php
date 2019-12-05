<?php


namespace Calc\Http\Router\Interfaces;


use Calc\Http\Router\Interfaces\RouteInterface;

interface RouteProxyInterface
{
    public function get(string $path, ?string $handler): RouteInterface;

    public function post(string $path, ?string $handler ): RouteInterface;

    public function middleware(callable $middleware): self ;

    public function group(callable $groupFunction): self ;

    public function name(string $name): self;
}