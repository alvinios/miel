<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Endpoint\Endpoint;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class NoContent implements Response, Endpoint
{
    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return $this->build($factory);
    }

    public function build(
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return $factory->createResponse(204)
          ->withStatus(204, 'No Content');
    }
}
