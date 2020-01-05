<?php

namespace Lil\Router;

use Lil\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        /**
         * @var $response Response
         */
        $response = null;

        if ($this->controller instanceof \Closure) {
            $response = call_user_func($this->controller, $request);
        } elseif (is_object($this->controller) && is_string($this->method) && method_exists($this->controller, $this->method)) {
            $response = $this->controller->{$this->method}(...$this->arguments);
        }

        if (!$response instanceof Response) {
            throw new \Exception('Controller must return '.Response::class.' object');
        }

        $response->send();
    }
}
