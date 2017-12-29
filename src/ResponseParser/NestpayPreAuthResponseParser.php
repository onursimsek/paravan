<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

class NestpayPreAuthResponseParser implements PreAuthResponseParserInterface
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }
}