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