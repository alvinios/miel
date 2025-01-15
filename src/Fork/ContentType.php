<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

class ContentType extends Header
{
    public function __construct(
        private string $type,
        Fork ...$forks,
    ) {
        parent::__construct('Content-type', $type, ...$forks);
    }
}
