<?php

declare(strict_types=1);

namespace Alvinios\Miel\Logic;

class HasNot implements Optional
{
    public function has(): bool
    {
        return false;
    }
}
