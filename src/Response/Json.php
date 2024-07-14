<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Json extends Base implements Response
{
    public function __construct(
        private readonly \JsonSerializable|array|\stdClass $content
    ) {
    }

    public function build(
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return $factory->createResponse(200)
          ->withBody($factory->createStream(json_encode($this->content)))
          ->withHeader('Content-Type', 'application/json');
    }
}
