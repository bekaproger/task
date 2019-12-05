<?php


namespace Calc\Http\Request;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class RequestFactory implements ServerRequestInterface
{
    private $protocolVersion;

    private $headers = null;

    private $headerNames = [];

    public static function createFromGlobals($GET, $POST, $FILES, $SERVER)
    {

    }

    private function getParamFromServer(string $name)
    {
        return $_SERVER[$name];
    }

    public function getProtocolVersion()
    {
        if (!$this->protocolVersion) {
            $this->protocolVersion = explode('/', $this->getParamFromServer('SERVER_PROTOCOL'))[1];
        }

        return $this->protocolVersion;

    }

    public function withProtocolVersion($version)
    {
        $th = clone $this;
        $th->protocolVersion = $version;
        return $th;
    }

    public function getHeaders()
    {
        if (!$this->headers) {
            $this->headers = [];
            foreach ($_SERVER as $name => $value)
            {
                if (substr($name, 0, 5) == 'HTTP_')
                {
                    $this->headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }

        return $this->headers;
    }

    public function hasHeader($name)
    {
        return array_key_exists($name, $this->getHeaders());
    }

    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return $this->getHeaders()[$name];
        }

        return null;
    }

    public function getHeaderLine($name)
    {

    }

    public function withHeader($name, $value)
    {
        $th = clone $this;
        if ($name) {
            $th->getHeaders()[RequestHelper::formatHeader($name)] = $value;
        }

        return $th;
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri()
    {
        // TODO: Implement getUri() method.
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }

    public function getServerParams()
    {
        // TODO: Implement getServerParams() method.
    }

    public function getCookieParams()
    {
        // TODO: Implement getCookieParams() method.
    }

    public function withCookieParams(array $cookies)
    {
        // TODO: Implement withCookieParams() method.
    }

    public function getQueryParams()
    {
        // TODO: Implement getQueryParams() method.
    }

    public function withQueryParams(array $query)
    {
        // TODO: Implement withQueryParams() method.
    }

    public function getUploadedFiles()
    {
        // TODO: Implement getUploadedFiles() method.
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        // TODO: Implement withUploadedFiles() method.
    }

    public function getParsedBody()
    {
        // TODO: Implement getParsedBody() method.
    }

    public function withParsedBody($data)
    {
        // TODO: Implement withParsedBody() method.
    }

    public function getAttributes()
    {
        // TODO: Implement getAttributes() method.
    }

    public function getAttribute($name, $default = null)
    {
        // TODO: Implement getAttribute() method.
    }

    public function withAttribute($name, $value)
    {
        // TODO: Implement withAttribute() method.
    }

    public function withoutAttribute($name)
    {
        // TODO: Implement withoutAttribute() method.
    }

}