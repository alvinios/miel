<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

class Accept extends Header
{
    public function __construct(
        private string $accept,
        Fork ...$forks,
    ) {
        parent::__construct('Accept', $accept, ...$forks);
    }
}
