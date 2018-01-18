<?php

namespace Paravan\RequestBuilder\Gvp;

use Paravan\RequestBuilder\GvpRequestBuilder;

class PreAuthRequestBuilder extends GvpRequestBuilder
{
    const SECURITY_LEVEL_3D = '3D';

    const SECURITY_LEVEL_3D_PAY = '3D_PAY',
        SECURITY_LEVEL_3D_FULL = '3D_FULL',
        SECURITY_LEVEL_3D_HALF = '3D_HALF';

    const SECURITY_LEVEL_CUSTUM_PAY = 'CUSTOM_PAY';

    /**
     * @return array
     */
    public function preAuth(): array
    {
        switch (mb_convert_case($this->configuration->getSecurityLevel(), MB_CASE_UPPER)) {
            case self::SECURITY_LEVEL_CUSTUM_PAY:
                return $this->securityLevelCustomPay();
                break;
            case self::SECURITY_LEVEL_3D:
            case self::SECURITY_LEVEL_3D_PAY:
            case self::SECURITY_LEVEL_3D_FULL:
            case self::SECURITY_LEVEL_3D_HALF:
            default:
                return $this->securityLevel3D();
                break;
        }
    }

    /**
     * @return array
     */
    protected function securityLevel3D(): array
    {
        return [
            'gateway' => $this->configuration->getGateway(),
            'mode' => $this->configuration->getMode(),
            'apiversion' => $this->configuration->getVersion(),
            'terminalid' => $this->configuration->getTerminalId(),
            'terminalprovuserid' => $this->configuration->getProvisionUser(),
            'terminaluserid' => $this->configuration->getTerminalUserId(),
            'terminalmerchantid' => $this->configuration->getMerchantId(),
            'txntype' => $this->configuration->getType(),
            'cardnumber' => $this->paravan->getCard()->getCardNumber(),
            'cardexpiredatemonth' => $this->formattedMonth($this->paravan->getCard()->getMonth()),
            'cardexpiredateyear' => $this->paravan->getCard()->getYear(),
            'cardcvv2' => $this->paravan->getCard()->getCvv(),
            'txnamount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
            'txncurrencycode' => $this->configuration->getCurrencyCode(),
            'txninstallmentcount' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
            'orderid' => $this->paravan->getOrder()->getId(),
            'successurl' => $this->configuration->getSuccessUrl(),
            'errorurl' => $this->configuration->getErrorUrl(),
            'customeremailaddress' => $this->paravan->getCustomer()->getEmail(),
            'customeripaddress' => $this->paravan->getCustomer()->getIp(),
            'secure3dsecuritylevel' => $this->configuration->getSecurityLevel(),
            'secure3dhash' => $this->hashDataForPreAuth(),
        ];
    }

    /**
     * @return array
     */
    protected function securityLevelCustomPay(): array
    {
        return [
            'gateway' => $this->configuration->getGateway(),
            'mode' => $this->configuration->getMode(),
            'apiversion' => $this->configuration->getVersion(),
            'terminalid' => $this->configuration->getTerminalId(),
            'terminalprovuserid' => $this->configuration->getProvisionUser(),
            'terminaluserid' => $this->configuration->getTerminalUserId(),
            'terminalmerchantid' => $this->configuration->getMerchantId(),
            'txntype' => $this->configuration->getType(),
            'txnsubtype' => $this->configuration->getSubType(),
            'garantipay' => 'Y',
            'companyname' => $this->configuration->getCompanyName(),
            'cardnumber' => $this->paravan->getCard()->getCardNumber(),
            'cardexpiredatemonth' => $this->formattedMonth($this->paravan->getCard()->getMonth()),
            'cardexpiredateyear' => $this->paravan->getCard()->getYear(),
            'cardcvv2' => $this->paravan->getCard()->getCvv(),
            'txnamount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
            'txncurrencycode' => $this->configuration->getCurrencyCode(),
            'txninstallmentcount' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
            'bnsuseflag' => $this->configuration->canUseBonus(),
            'fbbuseflag' => $this->configuration->canUseFirmBonus(),
            'chequeuseflag' => $this->configuration->canUseCheque(),
            'txntimeoutperiod' => $this->configuration->getTimeoutPeriod(),
            'orderid' => $this->paravan->getOrder()->getId(),
            'successurl' => $this->configuration->getSuccessUrl(),
            'errorurl' => $this->configuration->getErrorUrl(),
            'customeremailaddress' => $this->paravan->getCustomer()->getEmail(),
            'customeripaddress' => $this->paravan->getCustomer()->getIp(),
            'secure3dsecuritylevel' => $this->configuration->getSecurityLevel(),
            'secure3dhash' => $this->hashDataForPreAuth(),
            'txntimestamp' => time(),
            'refreshtime' => '1',
            'lang' => 'tr',
        ];
    }
}