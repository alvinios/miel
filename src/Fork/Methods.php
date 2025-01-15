<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

class Methods implements Fork
{
    private $forks;

    public function __construct(
        private array $methods,
        Fork ...$forks,
    ) {
        $this->forks = $forks;
    }

    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        if (in_array(
            strtolower($request->getMethod()),
            array_map(fn (string $method) => strtolower($method), $this->methods)
        )) {
            return (new Routes(...$this->forks))->route($request);
        }

        return new HasNot();
    }
}
