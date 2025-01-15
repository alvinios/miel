<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Twig\Environment;

class Twig extends Base implements Response
{
    public function __construct(
        private readonly Environment $environment,
        private readonly string $template,
        private readonly array $variables,
    ) {
    }

    public function build(
        ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return $responseFactory->createResponse(200)
          ->withBody(
              $streamFactory->createStream(
                  $this->environment->render(
                      $this->template,
                      $this->variables
                  )
              )
          )
          ->withHeader('Content-Type', 'text/html');
    }
}
