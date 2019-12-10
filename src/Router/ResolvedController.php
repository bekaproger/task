<?php


namespace Lil\Router;


use Lil\Http\Request;

class ResolvedController
{
    private $controller;

    private $arguments;

    private $method;

    public function __construct($controller, ?string $method = null, array $arguments = [])
    {
        $this->arguments = $arguments;
        $this->controller = $controller;
        $this->method = $method;
    }

    public function execute(Request $request)
    {
        if ($this->controller instanceof \Closure) {
           return call_user_func($this->controller, $request);
        } else if (is_object($this->controller) && is_string($this->method) && method_exists($this->controller, $this->method)) {
            return $this->controller->{$this->method}(...$this->arguments);
        }

        throw new \Exception("Controller or handler can't be executed");
    }
}