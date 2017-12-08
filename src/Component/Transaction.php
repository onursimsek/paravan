<?php

namespace Paravan\Component;

class Transaction
{
    private $authenticationCode;
    private $eci;
    private $txn;
    private $md;

    /**
     * Transaction constructor.
     * @param $authenticationCode
     * @param $eci
     * @param $txn
     * @param $md
     */
    public function __construct($authenticationCode, $eci, $txn, $md)
    {
        $this->authenticationCode = $authenticationCode;
        $this->eci = $eci;
        $this->txn = $txn;
        $this->md = $md;
    }

    /**
     * @return mixed
     */
    public function getAuthenticationCode()
    {
        return $this->authenticationCode;
    }

    /**
     * @return mixed
     */
    public function getEci()
    {
        return $this->eci;
    }

    /**
     * @return mixed
     */
    public function getTxn()
    {
        return $this->txn;
    }

    /**
     * @return mixed
     */
    public function getMd()
    {
        return $this->md;
    }
}