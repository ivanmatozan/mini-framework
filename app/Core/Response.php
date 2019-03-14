<?php

namespace App\Core;

/**
 * Class Response
 * @package App\Core
 */
class Response
{
    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var int 
     */
    protected $statusCode = 200;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function withStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Response
     */
    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function withJson($body): self
    {
        $this->withHeader('Content-Type', 'application/json');
        $this->setBody(json_encode($body));
        return $this;
    }
}
