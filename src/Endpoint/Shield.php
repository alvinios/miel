<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Http\Middleware\Unshield;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;

class Shield extends Fork
{
    public function __construct(
        private readonly MiddlewareInterface $middleware,
        private readonly Endpoint $endpoint,
    ) {
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return (new Unshield($this->endpoint, $responseFactory, $streamFactory, $this->middleware))->handle($request);
    }
}
