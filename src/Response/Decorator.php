<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseInterface;

interface Decorator
{
    public function response(ResponseInterface $response): ResponseInterface;
}
