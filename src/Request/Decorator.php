<?php

declare(strict_types=1);

namespace Alvinios\Miel\Request;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

abstract class Decorator implements ServerRequestInterface
{
    public function __construct(protected ServerRequestInterface $request)
    {
    }

    public function __call($name, $arguments)
    {
        if (is_callable([$this->request, $name])) {
            return call_user_func_array([$this->request, $name], $arguments);
        }
    }

    public function getServerParams()
    {
        return $this->request->getServerParams();
    }

    public function getCookieParams()
    {
        return $this->request->getCookieParams();
    }

    public function withCookieParams(array $cookies)
    {
        return $this->request->withCookieParams($cookies);
    }

    public function getQueryParams()
    {
        return $this->request->getQueryParams();
    }

    public function withQueryParams(array $query)
    {
        return $this->request->withQueryParams($query);
    }

    public function getUploadedFiles()
    {
        return $this->request->getUploadedFiles();
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        return $this->request->withUploadedFiles($uploadedFiles);
    }

    public function getParsedBody()
    {
        return $this->request->getParsedBody();
    }

    public function withParsedBody($data)
    {
        return $this->request->withParsedBody($data);
    }

    public function getAttributes()
    {
        return $this->request->getAttributes();
    }

    public function getAttribute(string $name, $default = null)
    {
        return $this->request->getAttribute($name, $default);
    }

    public function withAttribute(string $name, $value)
    {
        return $this->request->withAttribute($name, $value);
    }

    public function withoutAttribute(string $name)
    {
        return $this->request->withoutAttribute($name);
    }

    public function getRequestTarget()
    {
        return $this->request->getRequestTarget();
    }

    public function withRequestTarget(string $requestTarget)
    {
        return $this->request->withRequestTarget($requestTarget);
    }

    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function withMethod(string $method)
    {
        return $this->request->withMethod($method);
    }

    public function getUri()
    {
        return $this->request->getUri();
    }

    public function withUri(UriInterface $uri, bool $preserveHost = false)
    {
        return $this->request->withUri($uri, $preserveHost);
    }

    public function getProtocolVersion()
    {
        return $this->request->getProtocolVersion();
    }

    public function withProtocolVersion(string $version)
    {
        return $this->request->withProtocolVersion($version);
    }

    public function getHeaders()
    {
        return $this->request->getHeaders();
    }

    public function hasHeader(string $name)
    {
        return $this->request->hasHeader($name);
    }

    public function getHeader(string $name)
    {
        return $this->request->getHeader($name);
    }

    public function getHeaderLine(string $name)
    {
        return $this->request->getHeaderLine($name);
    }

    public function withHeader(string $name, $value)
    {
        return $this->request->withHeader($name, $value);
    }

    public function withAddedHeader(string $name, $value)
    {
        return $this->request->withAddedHeader($name, $value);
    }

    public function withoutHeader(string $name)
    {
        return $this->request->withoutHeader($name);
    }

    public function getBody()
    {
        return $this->request->getBody();
    }

    public function withBody(StreamInterface $body)
    {
        return $this->request->withBody($body);
    }
}
