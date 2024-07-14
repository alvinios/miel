<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

class QueryParam implements Fork
{
    private array $forks;

    public function __construct(
        private string $name,
        private string $value,
        Fork ...$forks
    ) {
        $this->forks = $forks;
    }

    public function route(
        ServerRequestInterface $request
    ): Endpoint|Optional {
        $params = $request->getQueryParams();

        if (isset($params[$this->name]) && $params[$this->name] === $this->value) {
            return (new Routes(...$this->forks))->route($request);
        }

        return new HasNot();
    }
}
