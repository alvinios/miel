<?php

declare(strict_types=1);

namespace Alvinios\Miel\Format;

class Low implements \Stringable
{
    public function __construct(
        private string|\Stringable $origin,
    ) {
    }

    public function __toString(): string
    {
        return \strtr($this->origin, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
    }
}
