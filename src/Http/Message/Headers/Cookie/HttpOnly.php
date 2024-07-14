<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http\Message\Headers\Cookie;

class HttpOnly implements OptionInterface
{
    public function __toString()
    {
        return 'HttpOnly';
    }
}
