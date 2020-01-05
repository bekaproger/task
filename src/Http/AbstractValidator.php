<?php

namespace Lil\Http;

abstract class AbstractValidator
{
    abstract public function handle(Request $request);

    public function messages()
    {
        return [];
    }
}
