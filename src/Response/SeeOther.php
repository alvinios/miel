<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Endpoint\Endpoint;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SeeOther implements Endpoint, Response
{
    public function __construct(
        private string $location,
        private string $text = '',
    ) {
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $this->build($responseFactory);
    }

    public function build(
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $responseFactory->createResponse(303)->withHeader('Location', $this->location);
    }
}
