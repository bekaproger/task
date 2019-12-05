<?php


namespace Calc\Http\Router;


class RouteCollection
{
    private static $routes = [];

    private static $middlewares = [];

    private static $route_counter = 0;

    public function getRoutes()
    {
        return self::$routes;
    }

    public function addRoute($methods, $pattern, $handler)
    {
        $route = new Route($methods, $pattern, $handler, self::$route_counter);
        self::$routes[self::$route_counter] = $route;
        self::$route_counter++;
        return $route;
    }

    public function addMiddleware(callable $middleware)
    {
        self::$middlewares[] = $middleware;
    }

    public function getMiddlewares()
    {
        return self::$middlewares;
    }
}