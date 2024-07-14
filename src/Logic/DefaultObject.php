<?php

declare(strict_types=1);

namespace Alvinios\Miel\Logic;

class DefaultObject
{
    public function __construct(private string $message)
    {
    }

    public function __call(string $name, array $arguments)
    {
        throw new \LogicException($this->message);
    }
}
