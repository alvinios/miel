<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class Expires implements OptionInterface
{
    public function __construct(
        private \DateTimeImmutable $expires
    ) {
    }

    public function __toString()
    {
        return sprintf('Expires=%s', $this->expires->format(\DateTime::COOKIE));
    }
}
