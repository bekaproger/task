<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;

class SampleController
{
    public function index (ServerRequestInterface $request)
    {
        echo 'You are here - ' . $request->getUri()->getPath();
    }
}