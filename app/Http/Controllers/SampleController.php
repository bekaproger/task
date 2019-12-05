<?php

namespace App\Http\Controllers;

use Calc\Http\Router\Interfaces\RouterInterface;
use Calc\Http\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

class SampleController
{
    public function index (ServerRequestInterface $request)
    {
        echo 'You are here - ' . $request->getUri()->getPath();
    }
}