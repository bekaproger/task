<?php

namespace Lil\Router;

class RouteCollection
{
    private static $routes = [];

    private static $route_counter = 0;

    private $stack = [];

    private $prefix = '';

    public function getRoutes()
    {
        return self::$routes;
    }

    public function addRoute($methods, $pattern, $handler)
    {
        $route = new Route($methods, $this->makePattern($pattern), $handler, self::$route_counter);
        $this->applyStack($route);
        self::$routes[self::$route_counter] = $route;
        ++self::$route_counter;

        return $route;
    }

    public function addStack(array $stack)
    {
        $this->stack[] = $stack;

        if (isset($stack['prefix'])) {
            if (empty($this->prefix)) {
                $this->prefix = trim($stack['prefix'], '/');
            } else {
                $this->prefix .= '/'.trim($stack['prefix'], '/');
            }
        }
    }

    public function popStack()
    {
        array_pop($this->stack);

        $this->prefix = substr($this->prefix, 0, strrpos($this->prefix, '/'));
    }

    protected function applyStack(Route $route)
    {
        foreach ($this->stack as $stack) {
            if (isset($stack['middleware']) && is_array($stack['middleware'])) {
                $route->middleware($stack['middleware']);
            }
        }
    }

    protected function makePattern($pattern)
    {
        return $this->prefix.'/'.trim(trim($pattern, ' '), '/');
    }
}
