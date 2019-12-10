<?php


namespace Lil\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Request extends SymfonyRequest
{
    public function uri()
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');

        return $pattern;
    }
}