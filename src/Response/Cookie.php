<?php

declare(strict_types=1);

namespace Alvinios\Miel\Response;

use Alvinios\Miel\Http\Message\Headers\Cookie\OptionInterface;
use Alvinios\Miel\Http\Message\Headers\HeaderValue;
use Psr\Http\Message\ResponseInterface;

class Cookie implements Decorator
{
    private $options;

    public function __construct(
        private string $name,
        private string $value,
        OptionInterface ...$options,
    ) {
        $this->options = $options;
    }

    public function __toString()
    {
        return (string) new HeaderValue(sprintf(
            '%s=%s;%s',
            $this->name,
            $this->value,
            implode(
                ';',
                array_map(
                    fn (OptionInterface $cookie) => (string) $cookie,
                    $this->options
                )
            )
        ));
    }

    public function response(ResponseInterface $response): ResponseInterface
    {
        return $response->withHeader(
            'Set-Cookie',
            (string) $this
        );
    }
}
