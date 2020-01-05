<?php

namespace Lil\Router;

use Lil\Application;
use Lil\Http\Request;

class ControllerResolver
{
    protected $request;

    protected $container;

    public function __construct(Application $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    public function getController(Route $route, array $params = []): ResolvedController
    {
        $arguments = [];

        if ($route->getHandler() instanceof \Closure) {
            return new ResolvedController($route->getHandler(), null, []);
        }

        $exploded = explode('@', $route->getHandler());
        $controller_class = 'App\\Http\\Controllers\\'.$exploded[0];

        if (2 != count($exploded)) {
            throw new \Exception('Controller name and class invalid in route '.$route->getName());
        }
        if (class_exists($controller_class)) {
            try {
                $instance = $this->container->get($controller_class);
            } catch (\Exception $e) {
                throw new \Exception("Controller class $controller_class can't be resolveed : ".$e->getMessage());
            }

            if (!method_exists($instance, $exploded[1])) {
                throw new \Exception('Method '.$exploded[0]." does not exist in $controller_class");
            }

            $arguments = $this->resolveControllerMethod($controller_class, $exploded[1], $params);

            return new ResolvedController($instance, $exploded[1], $arguments);
        }
    }

    protected function resolveControllerMethod(string $controller_class, string $method, $params)
    {
        $reflection = new \ReflectionMethod($controller_class, $method);

        $parameters = $reflection->getParameters();

        $arguments = [];

        /**
         * @var $parameter \ReflectionParameter
         */
        foreach ($parameters as $parameter) {
            if ($paramClass = $parameter->getClass()) {
                $arguments[] = $this->container->get($paramClass->getName());
            } else {
                if (isset($params[$parameter->getName()])) {
                    $arguments[] = $params[$parameter->getName()];
                } elseif ($parameter->isDefaultValueAvailable()) {
                    $arguments[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception('Unable to resolve "'.$parameter->getName().'"" in service "'.$controller_class.'"');
                }
            }
        }

        return $arguments;
    }
}
