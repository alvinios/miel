<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Resource extends Base
{
    public function __construct(
        private $resource,
    ) {
    }

    public function build(
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        if (is_resource($this->resource)) {
            throw new \InvalidArgumentException('Not a resource');
        }

        return $responseFactory->createResponse(200)
          ->withBody($streamFactory->createStreamFromResource($this->resource));
    }
}
