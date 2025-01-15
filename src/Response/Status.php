<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseInterface;

class Status implements Decorator
{
    public function __construct(
        private readonly int $status,
        private string $reasonPhrase = '',
    ) {
    }

    public function response(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus($this->status, $this->reasonPhrase);
    }
}
