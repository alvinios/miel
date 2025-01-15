<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Fork\Fork;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class Base implements Endpoint, Fork, Response, Optional
{
    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        return $this;
    }

    public function has(): bool
    {
        return true;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $this->build($responseFactory, $streamFactory);
    }

    abstract public function build(
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface;
}
