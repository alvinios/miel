<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class Path implements OptionInterface
{
    public function __construct(
        private string $path
    ) {
    }

    public function __toString()
    {
        return sprintf('Path=%s', $this->path);
    }
}
