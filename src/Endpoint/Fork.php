<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Fork\Fork as ForkInterface;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

abstract class Fork implements Endpoint, ForkInterface, Optional
{
    public function route(
        ServerRequestInterface $request
    ): Endpoint|Optional {
        return $this;
    }

    public function has(): bool
    {
        return true;
    }

    abstract public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface;
}
