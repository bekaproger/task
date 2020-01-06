<?php

namespace Lil\Router;

use Lil\ApplicationInterface;
use Lil\Router\Events\RouteMatchEvent;
use Lil\Router\Interfaces\RouterInterface;
use Lil\Http\Request;

class Router implements RouterInterface
{
    private $routes;

    private $resolver;

    private $app;

    public function __construct(RouteCollection $routes, ControllerResolver $resolver, ApplicationInterface $app)
    {
        $this->routes = $routes;
        $this->app = $app;
        $this->resolver = $resolver;
    }

    public function match(Request $request)
    {
        $method = $request->getMethod();
        if ('POST' === strtoupper($request->getMethod())) {
            $method = $this->getMethodFromForm($request);
        }

        /**
         * @var $route Route
         */
        foreach ($this->routes->getRoutes() as $route) {
            if (!in_array($method, $route->getMethods())) {
                continue;
            }

            $request_path = $request->path();
            $route_path = $route->getPattern();

            $pattern = preg_replace_callback('/\{([^\}]+)\}/', function ($match) use ($route) {
                $token = '[^\}]+';
                $param = $match[1]; // 'id'
                if (array_key_exists($param, $route->getConstraints())) {
                    $token = $route->getConstraints()[$param];
                }

                return '(?P<'.$param.'>'.$token.')';
            }, $route_path);

            if (preg_match('~^'.$pattern.'$~i', $request_path, $matches)) {
                $this->dispatchMiddlewares($route, $request);
                $matches = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);
                $resolved = $this->resolver->getController($route, $matches);

                dispatch(RouteMatchEvent::class);

                return $resolved;
            }
        }

        throw new \Exception('404');
    }

    private function dispatchMiddlewares(Route $route, Request $request)
    {
        $middlewares = config('middlewares');

        foreach ($route->getMiddlewares() as $middleware) {
            if (!is_string($middleware) && is_callable($middleware)) {
                $middleware($request, $this->app);
            } else {
                if (array_key_exists($middleware, $middlewares)) {
                    $class = $this->app->get($middlewares[$middleware]);
                    $class->handle($request);
                } else {
                    throw new \Exception("Unknown middleware $middleware!");
                }
            }
        }
    }

    private function getMethodFromForm(Request $request)
    {
        if ($method = $request->request->get('_method', null)) {
            return $method;
        }

        return $request->getMethod();
    }
}
