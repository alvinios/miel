<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Http\Message\Headers\HeaderName;
use Alvinios\Miel\Http\Message\Headers\HeaderValue;
use Psr\Http\Message\ResponseInterface;

class Header implements Decorator
{
    public function __construct(
        private readonly string $name,
        private readonly string $value,
    ) {
    }

    public function response(ResponseInterface $response): ResponseInterface
    {
        return $response->withHeader((string) new HeaderName($this->name), (string) new HeaderValue($this->value));
    }
}
