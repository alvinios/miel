<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Text extends Base implements Response
{
    public function __construct(
        private readonly string $text,
    ) {
    }

    public function build(
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $responseFactory->createResponse(200)
          ->withBody($streamFactory->createStream($this->text))
          ->withHeader('Content-Type', 'text/html');
    }
}
