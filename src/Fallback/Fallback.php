<?php

declare(strict_types=1);

namespace Alvinios\Miel\Fallback;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Request\WithException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Fallback implements Endpoint
{
    private $fallbacks;

    public function __construct(
        private Endpoint $endpoint,
        FallbackInterface ...$fallbacks
    ) {
        $this->fallbacks = $fallbacks;
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        try {
            return $this->endpoint->response($request, $factory);
        } catch (\Exception $ex) {
            foreach ($this->fallbacks as $fallback) {
                if ($fallback->supports($ex)) {
                    return $fallback->response(
                        new WithException($request->withAttribute(\Exception::class, $ex)),
                        $factory
                    );
                }
            }

            throw $ex;
        }
    }
}
