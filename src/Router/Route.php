<?php


namespace Lil\Router;


use Lil\Router\Interfaces\RouteInterface;

class Route implements RouteInterface
{
    private $methods = [];

    private $pattern;

    private $id;

    private $handler;

    private $middlewares = [];

    private $name;

    private $constraints = [];

    public function __construct($methods, $pattern, $handler, $id)
    {
        $this->pattern = $pattern;
        $this->methods = $methods;
        $this->id = $id;
        $this->handler = $handler;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getPattern()
    {
        return trim($this->pattern, '/');
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function middleware($middleware) : RouteInterface
    {
        if (is_array($middleware)) {
            foreach ($middleware as $value) {
                if (!is_callable($value)) {
                    throw new \Exception('Middleware must be callable or array of callable');
                }
            }
            $this->middlewares = array_merge($this->middlewares, $middleware);

            return $this;
        } else if (is_callable($middleware)) {
            $this->middlewares[] = $middleware;
            return $this;
        }
        throw new \Exception('Middleware must be callable or array of callable');
    }

    public function name(string $name) : RouteInterface
    {
        $this->name = $name;
        return $this;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @return array
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    public function where(array $constraints): RouteInterface
    {
        $this->constraints = array_merge($this->constraints, $constraints);
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
}