<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class Secure implements OptionInterface
{
    public function __toString()
    {
        return 'Secure';
    }
}
