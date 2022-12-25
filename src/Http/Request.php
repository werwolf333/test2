<?php

namespace Werwolf\Test2\Http;

class Request
{
    private $uri;
    private $method;
    private $body;
    private $headers;
    public function __construct(string $uri, string $method, string $body, array $headers)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public static function fromGlobals(): self
    {
        return new self(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            file_get_contents('php://input'),
            getallheaders()
        );
    }
}