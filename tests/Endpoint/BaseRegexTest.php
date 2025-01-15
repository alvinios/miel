<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Endpoint;

use Alvinios\Miel\Endpoint\BaseRegex;
use Alvinios\Miel\Fork\Methods;
use Alvinios\Miel\App;
use Alvinios\Miel\Request\WithRegex;
use Alvinios\Miel\Response\Response;
use Alvinios\Miel\Response\Text;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class BaseRegexTest extends TestCase
{
    public function testLogicExceptionIfNoRegexSupplied(): void
    {
        $this->expectException(\LogicException::class);
        $app = new App(
            new Methods(
                ['get'],
                new class extends BaseRegex {
                    public function act(WithRegex $request): Response
                    {
                        return new Text(
                            sprintf(
                                '%s',
                                $request->regex()->group('bar'),
                            )
                        );
                    }
                }
            )
        );

        $response = $app->response(new ServerRequest('GET', '/foo', []), new HttpFactory(), new HttpFactory());
    }
}
