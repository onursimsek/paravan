<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

class GvpPayResponseParser implements PayResponseParserInterface
{
    protected $response;

    protected $parsed;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->parsed = new \SimpleXMLElement($this->response->getBody()->getContents());
    }

    public function isSuccess(): bool
    {
        return (boolean)$this->parsed->Transaction->Response->ReasonCode == '00';
    }

    public function getErrorMessage(): string
    {
        return $this->parsed->Transaction->Response->ErrorMsg;
    }

    public function getErrorCode(): string
    {
        return $this->parsed->Transaction->Response->ReasonCode;
    }

    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }

    public function getTransactionId(): string
    {
        return $this->parsed->Transaction->RetrefNum;
    }
}