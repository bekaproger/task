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
        if ('GET' === $this->request->getMethod() && !$this->request->ajax()) {
            $this->request->getSession()->setPreviousUrl($this->request);
        }
        $this->request->decrementRequestSessionData();
    }
}
