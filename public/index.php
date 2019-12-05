<?php

use Symfony\Component\HttpFoundation\Request;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

require_once '../vendor/autoload.php';

$request = Request::createFromGlobals();
$psr17Factory = new Psr17Factory();
$psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
$request = $psrHttpFactory->createRequest($request);

$definitions = [
    Calc\Http\Router\Interfaces\RouterInterface::class => \Calc\Http\Router\Router::class,
    Psr\Container\ContainerInterface::class => Calc\Container\Container::class,
    ServerRequestInterface::class => function ($container) use ($request) {
        return $request;
    }
];

$container = new \Calc\Container\Container($definitions);
$app = $container->get(\Calc\Application::class);
$router = $container->get(\Calc\Http\Router\RouteProxy::class);

$router->get('{any}', 'SampleController@index')->where(['any' => '.*']);

$app->handle($request);




