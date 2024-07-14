<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fallback;

use Alvinios\Miel\Endpoint\Endpoint;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Any implements FallbackInterface
{
    public function __construct(
        private Endpoint $endpoint
    ) {
    }

    public function supports(\Throwable $exception): bool
    {
        return true;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return $this->endpoint->response($request, $factory);
    }
}
