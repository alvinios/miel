<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Fork;

use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Fork\Shield;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use Alvinios\Miel\Response\Text as TextResponse;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ShieldTest extends TestCase
{
    public function testDisallowMethodMiddleware(): void
    {
        $app = new Routes(
            new Shield(
                new Regex('/foo', new Text('Some content here...')),
                $this->disallowMethodMiddleware('PATCH', new HttpFactory())
            )
        );

        $this->assertEquals(
            405,
            $app->response(new ServerRequest('patch', '/foo', []), new HttpFactory())->getStatusCode()
        );

        $this->assertEquals(
            200,
            $app->response(new ServerRequest('get', '/foo', []), new HttpFactory())->getStatusCode()
        );
    }

    public function testNestedMiddlewares(): void
    {
        $app = new Routes(
            new Shield(
                new Shield(
                    new Regex(
                        '/foo/(?P<id>[\d]+)',
                        new class() extends Base {
                            public function act(ServerRequestInterface|WithRegex $request): Response
                            {
                                return new TextResponse(sprintf('Id is equal to %s', $request->regex()->group('id')));
                            }
                        }
                    ),
                    $this->disallowMethodMiddleware('PATCH', new HttpFactory())
                ),
                $this->disallowMethodMiddleware('POST', new HttpFactory()),
                $this->logPathMiddleware(new NullLogger())
            )
        );

        $this->assertEquals(
            405,
            $app->response(new ServerRequest('patch', '/foo/2', []), new HttpFactory())->getStatusCode()
        );

        $this->assertEquals(
            405,
            $app->response(new ServerRequest('post', '/foo/2', []), new HttpFactory())->getStatusCode()
        );

        $this->assertEquals(
            200,
            $app->response(new ServerRequest('get', '/foo/2', []), new HttpFactory())->getStatusCode()
        );

        $this->assertStringContainsStringIgnoringCase(
            '2',
            $app->response(
                new ServerRequest('get', '/foo/2', []),
                new HttpFactory()
            )->getBody()->getContents()
        );
    }

    private function disallowMethodMiddleware(
        string $method,
        ResponseFactoryInterface|StreamFactoryInterface $factory
    ): MiddlewareInterface {
        return new class($method, $factory) implements MiddlewareInterface {
            public function __construct(
                private string $method,
                private ResponseFactoryInterface|StreamFactoryInterface $factory
            ) {
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                if (strtolower($request->getMethod()) === strtolower($this->method)) {
                    return $this->factory
                        ->createResponse(405)
                        ->withBody($this->factory->createStream(sprintf('%s method is not allowed', $this->method)));
                }

                return $handler->handle($request);
            }
        };
    }

    private function logPathMiddleware(
        LoggerInterface $logger
    ): MiddlewareInterface {
        return new class($logger) implements MiddlewareInterface {
            public function __construct(
                private LoggerInterface $logger
            ) {
            }

            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $this->logger->debug($request->getUri()->getPath());

                return $handler->handle($request);
            }
        };
    }
}