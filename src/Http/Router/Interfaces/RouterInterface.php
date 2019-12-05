<?php


namespace Lil\Http\Router\Interfaces;


use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function match(ServerRequestInterface $request);
}