<?php


namespace LilHttp\Router\Interfaces;


interface ControllerResolverInterface
{
    public function getController(RouteInterface $route) : ResolvedControllerInterface;
}