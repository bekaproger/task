<?php

namespace Lil\Http;

interface ValidationInterface
{
    public static function validate(Request $request, AbstractValidator $validator);
}
