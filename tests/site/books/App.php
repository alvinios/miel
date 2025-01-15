<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Books;

use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Endpoint\Wrap;
use Alvinios\Miel\Fallback\Any;
use Alvinios\Miel\Fallback\Fallback;
use Alvinios\Miel\Fallback\Status as FallbackStatus;
use Alvinios\Miel\Fork\Append;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Response\Cookie;
use Alvinios\Miel\Response\Status;
use Alvinios\Miel\Response\Text;
use Alvinios\Miel\Response\Twig;
use Alvinios\Miel\Tests\Books\Book\Api as ApiRoutes;
use Alvinios\Miel\Tests\Books\Book\Books;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Twig\Environment;

class App implements Endpoint
{
    /**
     * Application dependencies.
     */
    public function __construct(
        private Environment $twig,
        private Books $books,
    ) {
    }

    public function response(
        ServerRequestInterface $request,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
    ): ResponseInterface {
        return (new Fallback(
            new Routes(
                new Append(
                    $this->routes(),
                    (new ApiRoutes($this->books))()
                )
            ),
            new FallbackStatus(
                404,
                new Wrap(
                    new Twig($this->twig, 'errors/404.html.twig', []),
                    new Status(404)
                )
            ),
            new Any(new Wrap(
                new Text('An error has occured'),
                new Status(500)
            ))
        ))->response($request, $responseFactory, $streamFactory);
    }

    /**
     * Application routes.
     */
    private function routes(): \Iterator
    {
        yield new Regex('^(/|/home)$', new Twig($this->twig, 'index.html.twig', []));

        yield new Regex(
            '/foo',
            new Wrap(
                new Text('<html><head></head><body>Some content goes here...</body></html>'),
                new Cookie('foo', 'yes')
            ),
        );
    }
}
