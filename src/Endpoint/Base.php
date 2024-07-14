<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Response\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class Base extends Fork
{
    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return $this->act($request)->build($factory);
    }

    abstract public function act(ServerRequestInterface $request): Response;
}
