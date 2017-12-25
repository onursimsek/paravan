<?php

namespace Paravan\Configuration;

class GvpConfiguration extends ConfigurationAbstract
{
    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var integer
     */
    protected $currencyCode;

    /**
     * @var integer
     */
    protected $cardholderPresentCode;

    /**
     * @var string
     */
    protected $motoInd;

    /**
     * @var string
     */
    protected $terminalId;

    /**
     * @var string
     */
    protected $terminalUserId;

    /**
     * @var string
     */
    protected $provisionUser;

    /**
     * @var string
     */
    protected $provisionPassword;

    /**
     * @var string
     */
    protected $storeKey;

    /**
     * @var string
     */
    protected $errorUrl;

    /**
     * @var string
     */
    protected $successUrl;

    /**
     * @var string
     */
    protected $securityLevel;

    public function __construct(array $configs)
    {
        $this->gateway = $configs['gateway'];
        $this->mode = $configs['mode'];
        $this->version = $configs['api_version'];
        $this->type = $configs['type'];
        $this->currencyCode = $configs['currency_code'];
        $this->cardholderPresentCode = $configs['cardholder_present_code'];
        $this->motoInd = $configs['moto_ind'];
        $this->merchantId = $configs['merchant_id'];
        $this->terminalId = $configs['terminal_id'];
        $this->terminalUserId = $configs['terminal_user_id'];
        $this->provisionUser = $configs['provision_user'];
        $this->provisionPassword = $configs['provision_password'];
        $this->storeKey = $configs['store_key'];
        $this->errorUrl = $configs['error_url'];
        $this->successUrl = $configs['success_url'];
        $this->securityLevel = $configs['security_level'];
    }

    /**
     * @return mixed
     */
    public function getTerminalId()
    {
        return $this->terminalId;
    }

    /**
     * @param mixed $terminalId
     * @return GvpConfiguration
     */
    public function setTerminalId($terminalId): GvpConfiguration
    {
        $this->terminalId = $terminalId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvisionUser()
    {
        return $this->provisionUser;
    }

    /**
     * @param mixed $provisionUser
     * @return GvpConfiguration
     */
    public function setProvisionUser($provisionUser): GvpConfiguration
    {
        $this->provisionUser = $provisionUser;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvisionPassword()
    {
        return $this->provisionPassword;
    }

    /**
     * @param mixed $provisionPassword
     * @return GvpConfiguration
     */
    public function setProvisionPassword($provisionPassword): GvpConfiguration
    {
        $this->provisionPassword = $provisionPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     * @return GvpConfiguration
     */
    public function setMode($mode): GvpConfiguration
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCurrencyCode(): int
    {
        return $this->currencyCode;
    }

    /**
     * @return int
     */
    public function getCardholderPresentCode(): int
    {
        return $this->cardholderPresentCode;
    }

    /**
     * @return string
     */
    public function getMotoInd(): string
    {
        return $this->motoInd;
    }

    /**
     * @return string
     */
    public function getTerminalUserId(): string
    {
        return $this->terminalUserId;
    }

    /**
     * @return string
     */
    public function getStoreKey(): string
    {
        return $this->storeKey;
    }

    /**
     * @return string
     */
    public function getErrorUrl(): string
    {
        return $this->errorUrl;
    }

    /**
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->successUrl;
    }

    /**
     * @return string
     */
    public function getSecurityLevel(): string
    {
        return $this->securityLevel;
    }
}