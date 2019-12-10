<?php


namespace Lil;

use Lil\Router\Interfaces\ResolvedControllerInterface;
use Lil\Router\Interfaces\RouterInterface;
use Lil\Http\Request;

class Application
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function handle(Request $request)
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