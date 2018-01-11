<?php

namespace Paravan\RequestBuilder;

abstract class GvpRequestBuilder extends RequestBuilder
{
    protected function formattedAmount($amount)
    {
        return $amount * 100;
    }

    protected function formattedInstallment($installment)
    {
        return $installment == 1 ? '' : $installment;
    }

    protected function formattedTerminalId($terminalId)
    {
        return str_pad($terminalId, 9, 0, STR_PAD_LEFT);
    }

    protected function hashDataForPreAuth()
    {
        $security = strtoupper(sha1($this->configuration->getProvisionPassword() . $this->formattedTerminalId($this->configuration->getTerminalId())));

        return strtoupper(sha1($this->configuration->getTerminalId() . $this->paravan->getOrder()->getId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $this->configuration->getSuccessUrl() . $this->configuration->getErrorUrl() . $this->configuration->getType() . $this->formattedInstallment($this->paravan->getOrder()->getInstallment()) . $this->configuration->getStoreKey() . $security));
    }

    protected function hashDataForPay()
    {
        $secureData = strtoupper(sha1($this->configuration->getProvisionPassword() . $this->formattedTerminalId($this->configuration->getTerminalId())));

        return strtoupper(sha1($this->paravan->getOrder()->getId() . $this->configuration->getTerminalId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $secureData));
    }
}