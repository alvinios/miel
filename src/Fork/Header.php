<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Format\Low;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

class Header implements Fork
{
    protected array $forks;

    public function __construct(
        private string $name,
        private string $value,
        Fork ...$forks,
    ) {
        $this->forks = $forks;
    }

    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        $headerLine = $request->getHeaderLine($this->name);

        if (str_contains((string) new Low($headerLine), (string) new Low($this->value))) {
            return (new Routes(...$this->forks))->route($request);
        }

        return new HasNot();
    }
}
