<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Middleware;

use Alvinios\Miel\Endpoint\Endpoint;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Unshield implements RequestHandlerInterface
{
    private array $middlewares;

    public function __construct(
        private Endpoint $endpoint,
        private ResponseFactoryInterface|StreamFactoryInterface $factory,
        MiddlewareInterface ...$middlewares
    ) {
        $this->middlewares = $middlewares;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (0 === count($this->middlewares)) {
            return $this->endpoint->response($request, $this->factory);
        }

        return $this->middlewares[0]->process(
            $request,
            new self($this->endpoint, $this->factory, ...array_slice($this->middlewares, 1))
        );
    }
}
