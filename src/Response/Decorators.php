<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseInterface;

class Decorators implements Decorator
{
    public function __construct(
        private array $decorators
    ) {
    }

    public function response(ResponseInterface $response): ResponseInterface
    {
        foreach ($this->decorators as $decorator) {
            $response = $decorator->response($response);
        }

        return $response;
    }
}
