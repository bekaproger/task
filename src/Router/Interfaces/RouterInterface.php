<?php


namespace Lil\Router\Interfaces;


use Lil\Http\Request;

interface RouterInterface
{
    public function match(Request $request);
}