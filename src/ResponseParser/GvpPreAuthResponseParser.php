<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

class GvpPreAuthResponseParser
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function redirect()
    {
        return $this->response->getBody()->getContents();
    }
}