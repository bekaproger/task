<?php

return [
    Lil\Router\Interfaces\RouterInterface::class => Lil\Router\Router::class,
    Lil\Container\ContainerInterface::class => Lil\Container\Container::class,
    Lil\Router\Interfaces\RouteProxyInterface::class => \Lil\Router\RouteProxy::class,
    \Lil\ApplicationInterface::class => \Lil\Application::class,
    \Lil\Authentication\AuthManagerInterface::class => \Lil\Authentication\Auth::class,
    Lil\Session\SessionInterface::class => function () {
        return \Lil\Session\Session::create();
    },
    'doctrine_manager' => function () {
        return \Lil\Db\DbFactory::createEntityManager();
    },
    'session' => function () {
        return \Lil\Session\Session::create();
    },
    'auth' => \Lil\Authentication\Auth::class,
];
