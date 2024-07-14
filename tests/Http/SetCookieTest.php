<?php

declare(strict_types=1);

namespace Alvinios\Miel\Tests\Http;

use Alvinios\Miel\Http\Message\Headers\Cookie\Domain;
use Alvinios\Miel\Http\Message\Headers\Cookie\MaxAge;
use Alvinios\Miel\Http\Message\Headers\Cookie\Path;
use Alvinios\Miel\Http\Message\Headers\Cookie\Secure;
use Alvinios\Miel\Response\Cookie;
use PHPUnit\Framework\TestCase;

class SetCookieTest extends TestCase
{
    public function testItHasNameAndValue()
    {
        $this->assertStringContainsString('foo=bar', (string) $this->cookie());
    }

    public function testItHasMaxAge()
    {
        $this->assertStringContainsString('Max-Age=3600', (string) $this->cookie());
    }

    public function testItHasSecure()
    {
        $this->assertStringContainsString('Secure', (string) $this->cookie());
    }

    public function testItHasDomain()
    {
        $this->assertStringContainsString('Domain=mydomain.com', (string) $this->cookie());
    }

    public function testItHasPath()
    {
        $this->assertStringContainsString('Path=/docs', (string) $this->cookie());
    }

    private function cookie(): Cookie
    {
        return new Cookie(
            'foo',
            'bar',
            new Domain('mydomain.com'),
            new MaxAge(3600),
            new Path('/docs'),
            new Secure()
        );
    }
}
