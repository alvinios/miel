<?php

declare(strict_types=1);

namespace Alvinios\Miel;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Fork\Fork;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Http\HttpException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class App implements Endpoint
{
    private array $forks;

    public function __construct(
        Fork ...$forks,
    ) {
        $this->forks = $forks;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        $endpoint = (new Routes(...$this->forks))->route($request);

        if ($endpoint->has()) {
            return $endpoint->response($request, $responseFactory, $streamFactory);
        }

        throw new HttpException('Sorry, no route matches this request', 404);
    }
}