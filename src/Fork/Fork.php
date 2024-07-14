<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A Fork represents a "node" of a routing "tree"
 */
interface Fork
{
    /**
     * When request satisfies a fork it returns an optional
     * endpoint (depending on subsequent forks)
     * @param ServerRequestInterface $request
     * @return Endpoint|Optional
     */
    public function route(
        ServerRequestInterface $request
    ): Endpoint|Optional;
}
