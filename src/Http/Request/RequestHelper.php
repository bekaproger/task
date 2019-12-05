<?php


namespace Calc\Http\Request;


class RequestHelper
{
    public static function formatHeader(string $name)
    {
        return str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
    }
}