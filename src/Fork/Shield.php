<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Endpoint\Shield as ShieldEndpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * Decorates Fork with middlewares.
 */
class Shield implements Fork
{
    public function __construct(
        private readonly MiddlewareInterface $middleware,
        private readonly Fork $origin
    ) {
    }

    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        $endpoint = $this->origin->route($request);

        if ($endpoint->has()) {
            return new ShieldEndpoint($this->middleware, $endpoint);
        }

        return new HasNot();
    }
}
