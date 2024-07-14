<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Fork;

use Alvinios\Miel\Fork\Cookie;
use Alvinios\Miel\Response\Text;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testRequestWithCookie()
    {
        $this->assertTrue(
            (new Cookie('yummy_cookie', 'choco', new Text('Testing cookie')))->route(
                (new ServerRequest('GET', '/', []))
                    ->withCookieParams(['yummy_cookie' => 'choco', 'tasty_cookie' => 'strawberry'])
            )->has());
    }

    public function testRequestWithoutCookie()
    {
        $this->assertFalse(
            (new Cookie('yummy_cookie', 'choco', new Text('Testing cookie')))->route(
                new ServerRequest('GET', '/', [])
            )->has());
    }
}
