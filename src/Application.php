<?php


namespace Calc;

use Calc\Http\Router\Interfaces\ResolvedControllerInterface;
use Calc\Http\Router\Interfaces\RouterInterface;
use Calc\Http\Router\RouteProxy;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function handle(ServerRequestInterface $request)
    {
        try {
            /**
             * @var $result ResolvedControllerInterface
             */
            $result = $this->router->match($request);
            $result->execute($request);
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}