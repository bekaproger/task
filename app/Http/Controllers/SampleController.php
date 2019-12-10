<?php

namespace App\Http\Controllers;

use Lil\Http\Request;

class SampleController
{
    public function index (Request $request)
    {
        echo 'You are here - ' . $request->path();
    }
}