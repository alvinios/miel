<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Fork;

use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Endpoint\Endpoint;
use Alvinios\Miel\Fork\Accept;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\App;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Json as JsonResponse;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ForkTest extends TestCase
{
    public function testForkedRouteReturnsHtmlIfAccepted(): void
    {
        $this->assertStringContainsString(
            'HTML',
            $this->app()->response(
                new ServerRequest(
                    'GET',
                    '/polymorphic/foo',
                    ['Accept' => ['text/html']]
                ),
                new HttpFactory(), new HttpFactory()
            )->getBody()->getContents()
        );
    }

    public function testForkedRouteReturnsJsonIfAccepted(): void
    {
        $obj = json_decode($this->app()->response(
            new ServerRequest('GET', '/polymorphic/bar', ['Accept' => ['application/json']]),
            new HttpFactory(), new HttpFactory()
        )->getBody()->getContents(), true);

        $this->assertContains('bar', $obj);
    }

    private function app(): Endpoint
    {
        return new App(
            new Regex(
                '/polymorphic/(?P<foo>[\w]+)',
                new Accept('text/html', new Text('<html><head></head><body>Some HTML</body></html>')),
                new Accept(
                    'application/json',
                    new class extends Base {
                        public function act(ServerRequestInterface|WithRegex $request): Response
                        {
                            return new JsonResponse(['foo' => $request->regex()->group('foo')]);
                        }
                    }
                )
            )
        );
    }
}
