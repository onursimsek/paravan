<?php

namespace Paravan\Configuration;

abstract class ConfigurationAbstract
{
    private $preAuthEndpoint;

    private $provisionEndpoint;

    private $merchantId;

    /**
     * @return mixed
     */
    public function getPreAuthEndpoint()
    {
        return $this->preAuthEndpoint;
    }

    /**
     * @return mixed
     */
    public function getProvisionEndpoint()
    {
        return $this->provisionEndpoint;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     * @return ConfigurationAbstract
     */
    public function setMerchantId($merchantId): ConfigurationAbstract
    {
        $this->merchantId = $merchantId;
        return $this;
    }
}