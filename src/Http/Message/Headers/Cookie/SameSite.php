<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class SameSite implements OptionInterface
{
    public function __construct(
        private string $value
    ) {
        if (!in_array($value, ['Strict', 'Lax', 'None'])) {
            throw new \InvalidArgumentException(sprintf('Invalid SameSite Cookie value: %s', $value));
        }
    }

    public function __toString()
    {
        return sprintf('SameSite=%s', $this->value);
    }
}
