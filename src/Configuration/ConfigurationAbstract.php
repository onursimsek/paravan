<?php

namespace Paravan\Configuration;

abstract class ConfigurationAbstract
{
    /**
     * @var string
     */
    protected $gateway;

    /**
     * @var string
     */
    protected $merchantId;

    /**
     * @return string
     */
    public function getGateway(): string
    {
        return $this->gateway;
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }
}