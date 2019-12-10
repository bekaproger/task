<?php


namespace Lil\Router\Interfaces;


use Lil\Http\Request;

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

    public function execute(Request $request);
}