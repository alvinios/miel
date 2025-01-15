<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Request\Regex\Regex as RegexMatcher;
use Alvinios\Miel\Request\Regex\RegexInterface;
use Alvinios\Miel\Request\WithRegex;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Regex extends Fork
{
    public function __construct(
        private Endpoint $origin,
        private RegexMatcher $regex,
    ) {
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $this->origin->response(
            new WithRegex($request->withAttribute(RegexInterface::class, $this->regex)),
            $responseFactory, $streamFactory
        );
    }
}
