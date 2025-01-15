<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers;

use Alvinios\Miel\Format\Low;

class HeaderName implements \Stringable
{
    public function __construct(
        private string $value,
    ) {
        if (1 !== \preg_match("@^[!#$%&'*+.^_`|~0-9A-Za-z-]+$@D", $value)) {
            throw new \InvalidArgumentException('Header name must be an RFC 7230 compatible string');
        }
    }

    /** Uppercase the first character of each word */
    public function __toString()
    {
        return ucwords($this->value, '-');
    }

    public function normalized(): string
    {
        return (string) new Low((string) $this);
    }
}
