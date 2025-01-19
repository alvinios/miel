<?php

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Endpoint\Shields as ShieldsEndpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Shields implements Fork
{
    private array $middlewares;

    public function __construct(
        private readonly Fork $origin,
        MiddlewareInterface ...$middlewares,
    ) {
        $this->middlewares = $middlewares;
    }

    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        $endpoint = $this->origin->route($request);

        if ($endpoint->has()) {
            return new ShieldsEndpoint($endpoint, ...$this->middlewares);
        }

        return new HasNot();
    }
}