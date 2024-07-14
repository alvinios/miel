<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Endpoint\Regex as RegexEndpoint;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Alvinios\Miel\Request\Regex\Regex as RegexMatcher;
use Psr\Http\Message\ServerRequestInterface;

/**
 * matching request path with a regex pattern
 */
class Regex implements Fork
{
    private $forks;

    public function __construct(
        private string $pattern,
        Fork ...$forks
    ) {
        $this->forks = $forks;
    }

    public function route(
        ServerRequestInterface $request
    ): Endpoint|Optional {
        $regex = new RegexMatcher(sprintf('@%s@i', $this->pattern), $request->getUri()->getPath());

        if ($regex->matches()) {
            $endpoint = (new Routes(...$this->forks))->route($request);

            if ($endpoint->has()) {
                return new RegexEndpoint($endpoint, $regex);
            }
        }

        return new HasNot();
    }
}
