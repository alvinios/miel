<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Response\Decorator;
use Alvinios\Miel\Response\Decorators;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Wrap extends Fork
{
    private array $decorators = [];

    public function __construct(private Endpoint $endpoint, Decorator ...$decorators)
    {
        $this->decorators = $decorators;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return (new Decorators($this->decorators))->response($this->endpoint->response($request, $responseFactory, $streamFactory));
    }
}
