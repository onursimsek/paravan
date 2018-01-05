<?php

namespace Paravan\Configuration;

class NestpayConfiguration extends ConfigurationAbstract
{
    const SECURITY_LEVEL_3D = '3d';
    const SECURITY_LEVEL_3D_PAY = '3d_pay';

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
    protected $mode;

    /**
     * @var integer
     */
    protected $cardholderPresentCode;

    /**
     * @var string
     */
    protected $lang;

    /**
     * @var integer
     */
    protected $currencyCode;

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

    /**
     * @var string
     */
    protected $rnd;

    public function __construct(array $configs)
    {
        $this->gateway = $configs['gateway'];
        $this->merchantId = $configs['merchant_id'];
        $this->provisionUser = $configs['provision_user'];
        $this->provisionPassword = $configs['provision_password'];
        $this->mode = $configs['mode'];
        $this->cardholderPresentCode = $configs['cardholder_present_code'];
        $this->lang = $configs['lang'] ?: 'tr';
        $this->currencyCode = $configs['currency_code'];
        $this->storeKey = $configs['store_key'];
        $this->errorUrl = $configs['error_url'];
        $this->successUrl = $configs['success_url'];
        $this->securityLevel = $configs['security_level'];
        $this->rnd = microtime();
    }

    /**
     * @return string
     */
    public function getProvisionUser(): string
    {
        return $this->provisionUser;
    }

    /**
     * @return string
     */
    public function getProvisionPassword(): string
    {
        return $this->provisionPassword;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
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
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getCurrencyCode(): int
    {
        return $this->currencyCode;
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

    /**
     * @return string
     */
    public function getRnd(): string
    {
        return $this->rnd;
    }
}