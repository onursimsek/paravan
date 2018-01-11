<?php

namespace Paravan\ResponseParser\Gvp;

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

    /**
     * @return bool
     */
    public function isRedirect(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }
}