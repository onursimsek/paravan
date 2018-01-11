<?php

namespace Paravan\ResponseParser\Gvp;

use Paravan\ResponseParser\PayResponseParserInterface;
use Psr\Http\Message\ResponseInterface;

class PayResponseParser implements PayResponseParserInterface
{
    protected $response;

    protected $parsed;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->parsed = new \SimpleXMLElement($this->response->getBody()->getContents());
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (boolean)$this->parsed->Transaction->Response->ReasonCode == '00';
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->parsed->Transaction->Response->ErrorMsg;
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->parsed->Transaction->Response->ReasonCode;
    }

    /**
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->parsed->Transaction->RetrefNum;
    }
}