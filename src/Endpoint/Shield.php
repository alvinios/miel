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
    private array $middlewares;

    public function __construct(
        private readonly Endpoint $endpoint,
        MiddlewareInterface ...$middlewares
    ) {
        $this->middlewares = $middlewares;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return (new Unshield($this->endpoint, $factory, ...$this->middlewares))->handle($request);
    }
}
