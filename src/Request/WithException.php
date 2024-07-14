<?php

declare(strict_types=1);

namespace Alvinios\Miel\Request;

use Alvinios\Miel\Logic\DefaultObject;

class WithException extends Decorator
{
    public function exception(): \Throwable
    {
        return $this->request->getAttribute(
            \Exception::class,
            new DefaultObject('No exception available with this Server Request')
        );
    }
}
