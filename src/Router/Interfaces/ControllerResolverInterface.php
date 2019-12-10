<?php


namespace Lil\Router\Interfaces;


interface ControllerResolverInterface
{
    public function getController(RouteInterface $route) : ResolvedControllerInterface;
}