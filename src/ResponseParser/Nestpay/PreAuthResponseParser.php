<?php

namespace Paravan\ResponseParser\Nestpay;


use Paravan\ResponseParser\PreAuthResponseParserInterface;
use Psr\Http\Message\ResponseInterface;

class PreAuthResponseParser implements PreAuthResponseParserInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

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