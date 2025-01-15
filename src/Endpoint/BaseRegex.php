<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class BaseRegex extends Fork
{
    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $this->act(new WithRegex($request))->build($responseFactory, $streamFactory);
    }

    abstract public function act(WithRegex $request): Response;
}
