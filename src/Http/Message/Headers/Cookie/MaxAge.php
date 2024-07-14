<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class MaxAge implements OptionInterface
{
    public function __construct(
        private int $seconds
    ) {
    }

    public function __toString()
    {
        return sprintf('Max-Age=%s', $this->seconds);
    }
}
