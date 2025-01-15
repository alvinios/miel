<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Http;

use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\App;
use Alvinios\Miel\Http\HttpException;
use Alvinios\Miel\Response\Text;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class HttpExceptionTest extends TestCase
{
    public function testHttpException(): void
    {
        $this->expectException(HttpException::class);

        $response = (new App(
            new Regex('/foo', new Text('Some information'))
        ))->response(
            new ServerRequest('GET', '/bar', []),
            new HttpFactory(), new HttpFactory()
        );
    }
}
