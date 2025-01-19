<?php

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Http\Middleware\Unshield;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;

class Shields extends Fork implements Endpoint
{
    private array $middlewares;

    public function __construct(
        private readonly Endpoint $endpoint,
        MiddlewareInterface ...$middlewares,
    ) {
        $this->middlewares = $middlewares;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return (new Unshield($this->endpoint, $responseFactory, $streamFactory, ...$this->middlewares))->handle($request);
    }
}