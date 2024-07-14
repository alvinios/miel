<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class Domain implements OptionInterface
{
    public function __construct(
        private string $domain
    ) {
    }

    public function __toString()
    {
        return sprintf('Domain=%s', $this->domain);
    }
}
