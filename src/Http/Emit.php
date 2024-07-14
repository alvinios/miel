<?php

declare(strict_types=1);

namespace Alvinios\Miel\Http;

use http\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface;

class Emit
{
    /**
     * Emits a response for a PHP SAPI environment.
     *
     * Emits the status line and headers via the header() function, and the
     * body content via the output buffer.
     */
    public function __invoke(ResponseInterface $response): bool
    {
        if (\headers_sent()) {
            throw new RuntimeException('Headers already sent');
        }

        if (\ob_get_level() > 0 && \ob_get_length() > 0) {
            throw new RuntimeException('Content already sent');
        }

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }
        }

        $reasonPhrase = $response->getReasonPhrase();
        $statusCode = $response->getStatusCode();

        header(sprintf(
            'HTTP/%s %d%s',
            $response->getProtocolVersion(),
            $statusCode,
            $reasonPhrase ? ' '.$reasonPhrase : ''
        ), true, $statusCode);

        echo $response->getBody();

        return true;
    }
}
