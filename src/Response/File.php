<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Http\HttpException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class File implements Response
{
    public function __construct(private string $file)
    {
    }

    public function build(
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): ResponseInterface {
        if (!is_file($this->file)) {
            throw new HttpException(sprintf('No such file %s', $this->file), 404);
        }

        return $factory->createResponse(200)
            ->withBody($factory->createStreamFromFile($this->file));
    }
}
