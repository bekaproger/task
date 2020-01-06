<?php

namespace App\Http\Controllers;

use Lil\Http\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return view('index');
    }
}
