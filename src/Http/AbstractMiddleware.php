<?php

namespace Lil\Http;

abstract class AbstractMiddleware
{
    abstract public function handle(Request $request);
}
