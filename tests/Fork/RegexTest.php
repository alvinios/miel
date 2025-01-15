<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Fork;

use Alvinios\Miel\Endpoint\Base;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\Fork\Routes;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use Alvinios\Miel\Response\Text as TextResponse;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RegexTest extends TestCase
{
    public function testTextContentIsReturned(): void
    {
        $response = (new Routes(
            new Regex('/', new Text('Some information'))
        ))->response(new ServerRequest('GET', '/', []), new HttpFactory(), new HttpFactory());

        $this->assertStringContainsString(
            'Some information',
            $response->getBody()->getContents()
        );
    }

    public function testRouteWithRegexGroups(): void
    {
        $response = (new Routes(
            new Regex(
                '/foo/(?P<baz>[\w]+)/(?P<bar>[\w]+)',
                new class extends Base {
                    public function act(ServerRequestInterface|WithRegex $request): Response
                    {
                        return new TextResponse(
                            sprintf(
                                '%s - %s',
                                $request->regex()->group('bar'),
                                $request->regex()->group('baz')
                            )
                        );
                    }
                }
            )
        ))->response(new ServerRequest('GET', '/foo/first/second'), new HttpFactory(), new HttpFactory());

        $this->assertStringContainsString('second - first', $response->getBody()->getContents());
    }
}
