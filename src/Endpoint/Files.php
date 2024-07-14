<?php

declare(strict_types=1);

namespace Alvinios\Miel\Endpoint;

use Alvinios\Miel\Response\File;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class Files extends Fork
{
    public function __construct(
        private readonly string $directory
    ) {
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        if (!is_dir($this->directory)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid path', $this->directory));
        }

        return (new File(
            sprintf(
                '%s/%s',
                rtrim($this->directory, '/'),
                ltrim($request->getUri()->getPath(), '/')
            )
        ))->build($factory);
    }
}
