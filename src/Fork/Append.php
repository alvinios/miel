<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Appends multiple iterators yielding forks.
 */
class Append implements Fork
{
    private \Traversable $forks;

    public function __construct(
        \Iterator ...$iterators
    ) {
        $this->forks = new \AppendIterator();
        array_walk($iterators, fn (\Iterator $iterator) => $this->forks->append($iterator));
    }

    public function route(
        ServerRequestInterface $request
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
