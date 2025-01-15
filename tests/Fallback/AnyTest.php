<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Fallback;

use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Fallback\Any;
use Alvinios\Miel\Fallback\Fallback;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Request\WithException;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use Alvinios\Miel\Response\Text as TextResponse;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class AnyTest extends TestCase
{
    public function testItWillDisplayFallbackText(): void
    {
        $response = (new Fallback(
            new Routes(
                new Regex(
                    '/foo',
                    new class extends Base {
                        public function act(ServerRequestInterface $request): Response
                        {
                            throw new \RuntimeException('there was an error');
                        }
                    }
                )
            ),
            new Any(new Text('Athens'))
        ))->response(
            new ServerRequest('GET', '/foo', []),
            new HttpFactory(), new HttpFactory()
        );

        $this->assertStringContainsString('Athens', $response->getBody()->getContents());
    }

    public function testItCanDisplayExceptionMessage(): void
    {
        $response = (new Fallback(
            new Routes(
                new Regex(
                    '/foo',
                    new class extends Base {
                        public function act(ServerRequestInterface $request): Response
                        {
                            throw new \RuntimeException('Cool exception');
                        }
                    }
                )
            ),
            new Any(
                new class extends Base {
                    public function act(ServerRequestInterface|WithException $request): Response
                    {
                        return new TextResponse($request->exception()->getMessage());
                    }
                }
            )
        ))->response(
            new ServerRequest('GET', '/foo', []),
            new HttpFactory(), new HttpFactory()
        );

        $this->assertStringContainsString('Cool exception', $response->getBody()->getContents());
    }
}
