<?php


namespace Calc\Http\Router\Interfaces;


use Psr\Http\Message\ServerRequestInterface;

interface ControllerResolverInterface
{
    public function getController(RouteInterface $route) : ResolvedControllerInterface;
}