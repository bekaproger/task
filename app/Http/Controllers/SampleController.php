<?php

namespace App\Http\Controllers;

use App\Model\User;
use Lil\Http\AbstractController;
use Lil\Http\Request;

class SampleController extends AbstractController
{
    public function index(Request $request, $any)
    {
        $user = $this->getManager()->getRepository(User::class)->find(1);

        return view('index', ['any' => $any]);
    }
}
