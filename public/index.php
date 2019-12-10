<?php

use Lil\Http\Request;
use Lil\Router\Interfaces\RouterInterface;
use Lil\Router\Router;
use Lil\Application;
use Lil\Router\RouteProxy;
use Lil\Container\Container;
use Lil\Container\ContainerInterface;

require_once '../vendor/autoload.php';

$request = Request::createFromGlobals();

$definitions = [
    RouterInterface::class    => Router::class,
    ContainerInterface::class => Container::class,
    Request::class            => function ($container) use ($request) {
        return $request;
    }
];

$container = new Container($definitions);
$app = $container->get(Application::class);

/**
 * @var  $router RouteProxy;
 */
$router = $container->get(RouteProxy::class);

$router->get('/{any}/', 'SampleController@index')->where(['any' => '.*']);

$app->handle($request);




