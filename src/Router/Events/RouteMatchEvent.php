<?php

namespace Lil\Router\Events;

use Lil\Http\Request;

class RouteMatchEvent
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $this->request->decrementRequestSessionData();
    }
}
