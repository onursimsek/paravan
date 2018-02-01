<?php

namespace Paravan\ResponseParser\Nestpay;

use Paravan\ResponseParser\PayResponseParserInterface;
use Psr\Http\Message\ResponseInterface;

class PayResponseParser implements PayResponseParserInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    protected $parsed;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->parsed = new \SimpleXMLElement($this->response->getBody()->getContents());
    }

    public function isSuccess(): bool
    {
        return (boolean)$this->parsed->Response == 'Approved';
    }

    public function getErrorMessage(): string
    {
        return (string)$this->parsed->ErrMsg;
    }

    public function getErrorCode(): string
    {
        return (string)$this->parsed->Extra->ERRORCODE;
    }

    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }

    public function getTransactionId(): string
    {
        return (string)$this->parsed->TransId;
    }
}