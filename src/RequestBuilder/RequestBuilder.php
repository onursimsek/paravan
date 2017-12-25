<?php

namespace Paravan\RequestBuilder;

use Paravan\Configuration\ConfigurationAbstract;
use Paravan\Gateway\GatewayInterface;
use Paravan\Paravan;

abstract class RequestBuilder
{
    const PRE_AUTH_REQUEST = 'preAuth';
    const PAY_REQUEST = 'pay';

    /**
     * @var ConfigurationAbstract
     */
    protected $configuration;

    /**
     * @var Paravan
     */
    protected $paravan;

    /**
     * @var GatewayInterface
     */
    protected $gateway;

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;

        $this->paravan = $this->gateway->getParavan();
        $this->configuration = $this->paravan->getConfiguration();
    }

    protected function formattedAmount($amount)
    {
        return $amount;
    }

    protected function formattedInstallment($installment)
    {
        return $installment;
    }

    protected function formattedMonth($month)
    {
        return \DateTime::createFromFormat('n', $month)->format('m');
    }

    protected function formattedYear($year)
    {
        return $year;
    }

    abstract protected function hashDataForPreAuth();

    abstract protected function hashDataForPay();
}