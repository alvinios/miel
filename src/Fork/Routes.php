<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

/**
 * forks aggregation.
 */
class Routes implements Fork
{
    private array $forks;

    public function __construct(
        Fork ...$forks,
    ) {
        $this->forks = $forks;
    }

    public function route(
        ServerRequestInterface $request,
    ): Endpoint|Optional {
        foreach ($this->forks as $route) {
            $solution = $route->route($request);

            if ($solution->has()) {
                return $solution;
            }
        }

        return new HasNot();
    }
}
