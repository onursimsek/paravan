<?php

namespace Paravan\ResponseParser\Nestpay;

use Psr\Http\Message\ResponseInterface;

class StatusResponseParser
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

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->parsed->Response == 'Accepted';
    }

    /**
     * @return bool
     */
    public function isCancel(): bool
    {
        return $this->parsed->Response == 'Declined';
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->parsed->TransId;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->parsed->ErrMsg;
    }

    /**
     * @return string
     */
    public function getRawResponse(): string
    {
        return $this->response->getBody()->getContents();
    }
}