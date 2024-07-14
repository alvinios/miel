<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Response;

use Alvinios\Miel\Response\Twig;
use GuzzleHttp\Psr7\HttpFactory;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigTest extends TestCase
{
    public function testItDisplaysTemplateVariables(): void
    {
        $twig = new Environment(
            new FilesystemLoader(dirname(__DIR__).'/resources'),
            []
        );

        $this->assertStringContainsString(
            'Rome',
            (new Twig(
                $twig,
                'index.html.twig',
                ['city' => 'Rome']
            ))->response(
                new ServerRequest('/', 'GET'),
                new HttpFactory()
            )->getBody()->getContents()
        );
    }
}
