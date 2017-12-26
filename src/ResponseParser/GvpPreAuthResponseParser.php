<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

class GvpPreAuthResponseParser implements PreAuthResponseInterface
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