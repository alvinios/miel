<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fork;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Http\HttpException;
use Alvinios\Miel\Logic\HasNot;
use Alvinios\Miel\Logic\Optional;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * forks aggregation.
 */
class Routes implements Fork, Endpoint
{
    private array $forks;

    public function __construct(
        Fork ...$forks
    ) {
        $this->forks = $forks;
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

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        $endpoint = $this->route($request);

        if ($endpoint->has()) {
            return $endpoint->response($request, $factory);
        }

        throw new HttpException('Sorry, no route matches this request', 404);
    }
}
