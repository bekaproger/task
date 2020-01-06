<?php

namespace Lil\Router\Interfaces;

interface RouteProxyInterface
{
    public function get(string $path, ?string $handler): RouteInterface;

    public function post(string $path, ?string $handler): RouteInterface;

    public function delete(string $path, ?string $handler): RouteInterface;

    public function put(string $path, ?string $handler): RouteInterface;

    public function options(string $path, ?string $handler): RouteInterface;

    public function patch(string $path, ?string $handler): RouteInterface;

    public function head(string $path, ?string $handler): RouteInterface;

    public function addRoute($methods, $pattern, $handler);

    public function group(array $options, callable $groupFunction);

    public function name(string $name): self;
}
