<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseInterface;

class Type implements Decorator
{
    public function __construct(
        private readonly string $type
    ) {
    }

    public function response(ResponseInterface $response): ResponseInterface
    {
        return $response->withHeader('Content-type', $this->type);
    }
}
