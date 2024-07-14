<?php

declare(strict_types=1);

namespace Alvinios\Miel\Request;

use Alvinios\Miel\Logic\DefaultObject;
use Alvinios\Miel\Request\Regex\RegexInterface;

class WithRegex extends Decorator
{
    public function regex(): RegexInterface|DefaultObject
    {
        return $this->request->getAttribute(
            RegexInterface::class,
            new DefaultObject('No Regex available with this Server Request')
        );
    }
}
