<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers;

class HeaderValue implements \Stringable
{
    public function __construct(
        private string $value,
    ) {
        if (1 !== \preg_match("@^[ \t\x21-\x7E\x80-\xFF]*$@", (string) $value)) {
            throw new \InvalidArgumentException('Header values must be RFC 7230 compatible strings');
        }
    }

    public function __toString()
    {
        return \trim((string) $this->value, " \t");
    }
}
