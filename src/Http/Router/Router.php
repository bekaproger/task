<?php


namespace Lil\Http\Router;

use Lil\Http\Router\Interfaces\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface
{
    private $routes;

    private $resolver;

    public function __construct(RouteCollection $routes, ControllerResolver $resolver)
    {
        $this->routes = $routes;
        $this->resolver = $resolver;
    }

    public function match(ServerRequestInterface $request)
    {
        /**
         * @var $route Route
         */
        foreach ($this->routes->getRoutes() as $route) {
            if (!in_array(strtoupper($request->getMethod()), $route->getMethods())) {
                continue;
            }

            $request_path = $this->dropSlashes($request->getUri()->getPath());
            $route_path = $this->dropSlashes($route->getPattern());

            $pattern = preg_replace_callback('/\{([^\}]+)\}/',function($match) use ($route) {
                $token = '[^\}]+';
                $param = $match[1]; // 'id'
                if (array_key_exists($param, $route->getConstraints())) {
                    $token = $route->getConstraints()[$param];
                }
                return '(?P<'. $param . '>' . $token . ')';
            }, $route_path);

            if (preg_match('~^' . $pattern . '$~i', $request_path, $matches)) {
                $this->dispatchMiddlewares($route, $request);
                $matches = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);
                $resolved = $this->resolver->getController($route, $matches);

                return $resolved;
            }
        }

        throw new \Exception('404');
    }

    private function dispatchMiddlewares (Route $route, ServerRequestInterface $request)
    {
        foreach ($this->routes->getMiddlewares() as $middleware) {
            $middleware($request);
        }

        foreach ($route->getMiddlewares() as $middleware) {
            $middleware($request);
        }
    }

    private function getRouteParams()
    {

    }

    private function dropSlashes(string $path)
    {
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        if (strrpos($path, '/') === strlen($path) - 1) {
            $path = substr($path, 0, -1);
        }

        return $path;
    }
}