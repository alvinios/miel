<?php

declare(strict_types=1);

namespace Alvinios\Miel\Request\Regex;

interface RegexInterface
{
    public function matches(): bool;

    public function group(string $name): string;
}
