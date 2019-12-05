<?php

use Symfony\Component\HttpFoundation\Request;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Lil\Http\Router\Interfaces\RouterInterface;
use Lil\Http\Router\Router;
use Lil\Application;
use Lil\Http\Router\RouteProxy;
use Lil\Container\Container;

require_once '../vendor/autoload.php';

$request = Request::createFromGlobals();
$psr17Factory = new Psr17Factory();
$psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
$request = $psrHttpFactory->createRequest($request);

$definitions = [
    RouterInterface::class => Router::class,
    Psr\Container\ContainerInterface::class => Container::class,
    ServerRequestInterface::class => function ($container) use ($request) {
        return $request;
    }
];

$container = new Container($definitions);
$app = $container->get(Application::class);
$router = $container->get(RouteProxy::class);

$router->get('{any}', 'SampleController@index')->where(['any' => '.*']);

$app->handle($request);




