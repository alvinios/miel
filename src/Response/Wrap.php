<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Wrap implements Response
{
    private array $decorators = [];

    public function __construct(private Response $response, Decorator ...$decorators)
    {
        $this->decorators = $decorators;
    }

    public function build(
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        return (new Decorators($this->decorators))->response($this->response->build($factory));
    }
}
