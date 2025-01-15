<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Result;

use Alvinios\Miel\Endpoint\Files;
use Alvinios\Miel\Fork\Regex;
use Alvinios\Miel\App;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testItDsiplaysFileContents(): void
    {
        $this->assertStringContainsString(
            'User-agent',
            (new App(
                new Regex('/robots\.txt', new Files(dirname(__DIR__).'/resources'))
            ))->response(
                new ServerRequest('GET', '/robots.txt', []), new HttpFactory(), new HttpFactory()
            )->getBody()->getContents()
        );
    }
}
