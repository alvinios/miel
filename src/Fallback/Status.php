<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fallback;

use Alvinios\Miel\Endpoint\Endpoint;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Status implements FallbackInterface
{
    public function __construct(
        private int $status,
        private Endpoint $endpoint,
    ) {
    }

    public function supports(\Throwable $exception): bool
    {
        return $this->status === $exception->getCode();
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $this->endpoint->response($request, $responseFactory, $streamFactory);
    }
}
