<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fallback;

use Alvinios\Miel\Endpoint\Endpoint;

interface FallbackInterface extends Endpoint
{
    public function supports(\Throwable $exception): bool;
}
