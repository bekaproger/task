<?php

namespace Lil\Router;

use Lil\Router\Interfaces\RouteProxyInterface;
use Lil\Router\Interfaces\RouteInterface;

class RouteProxy implements RouteProxyInterface
{
    protected $routes;

    protected $stack;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function addRoute($methods, $pattern, $handler)
    {
        return $this->routes->addRoute($methods, $pattern, $handler);
    }

    public function get(string $pattern, $handler): RouteInterface
    {
        $route = $this->addRoute(['GET'], $pattern, $handler);

        return $route;
    }

    public function post(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['POST'], $pattern, $handler);
    }

    public function put(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['PUT'], $pattern, $handler);
    }

    public function delete(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['DELETE'], $pattern, $handler);
    }

    public function head(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['HEAD'], $pattern, $handler);
    }

    public function options(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['OPTIONS'], $pattern, $handler);
    }

    public function patch(string $pattern, $handler): RouteInterface
    {
        return $this->addRoute(['PATCH'], $pattern, $handler);
    }

    public function name(string $name): RouteProxyInterface
    {
        return $this;
    }

    public function group(array $options, callable $function)
    {
        $this->routes->addStack($options);

        $function($this);

        $this->routes->popStack();

        return null;
    }

    public function middleware(callable $middleware): RouteProxyInterface
    {
        $this->routes->addMiddleware($middleware);

        return $this;
    }
}
