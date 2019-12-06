<?php


namespace Lil\Http\Router;

use Lil\Http\Router\Interfaces\RouteProxyInterface;

use Lil\Http\Router\Interfaces\RouteInterface;

class RouteProxy implements RouteProxyInterface
{
    private $rout_counter = 0;

    private $routes;

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
        return $this->addRoute(['GET'], $pattern, $handler);
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

    public function group(callable  $function): RouteProxyInterface
    {
        return $this;
    }

    public function middleware(callable $middleware): RouteProxyInterface
    {
        $this->routes->addMiddleware($middleware);
        return $this;
    }
}