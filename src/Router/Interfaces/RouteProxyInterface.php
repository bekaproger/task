<?php


namespace Lil\Router\Interfaces;


interface RouteProxyInterface
{
    public function get(string $path, ?string $handler): RouteInterface;

    public function post(string $path, ?string $handler ): RouteInterface;

    public function middleware(callable $middleware): self ;

    public function group(array $options, callable $groupFunction);

    public function name(string $name): self;
}