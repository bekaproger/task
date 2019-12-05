<?php


namespace Calc\Http\Router\Interfaces;


use Psr\Http\Message\ServerRequestInterface;

interface ResolvedControllerInterface
{
    /**
     * @return object
     */
    public function getController(): object;

    /**
     * @return array
     */
    public function getArguments(): array;

    /**
     * @return string
     */
    public function getMethod(): string;

    public function execute(ServerRequestInterface $request);
}