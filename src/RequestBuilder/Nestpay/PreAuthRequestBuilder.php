<?php

namespace Paravan\RequestBuilder\Nestpay;

use Paravan\Gateway\NestpayAbstract;
use Paravan\RequestBuilder\NestpayRequestBuilder;

class PreAuthRequestBuilder extends NestpayRequestBuilder
{
    public function preAuth(): array
    {
        switch (mb_convert_case($this->configuration->getSecurityLevel(), MB_CASE_UPPER)) {
            case NestpayAbstract::SECURITY_LEVEL_3D_PAY:
            default:
                return $this->securityLevel3DPay();
                break;
        }
    }

    public function securityLevel3DPay()
    {
        return [
            'gateway' => $this->configuration->getGateway(),
            'clientid' => $this->configuration->getMerchantId(),
            'oid' => $this->paravan->getOrder()->getId(),
            'amount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
            'okUrl' => $this->configuration->getSuccessUrl(),
            'failUrl' => $this->configuration->getErrorUrl(),
            'rnd' => $this->configuration->getRnd(),
            'hash' => $this->hashDataForPreAuth(),
            'storetype' => $this->configuration->getSecurityLevel(),
            'lang' => $this->configuration->getLang(),
            'currency' => $this->configuration->getCurrencyCode(),
            'pan' => $this->paravan->getCard()->getCardNumber(),
            'cv2' => $this->paravan->getCard()->getCvv(),
            'taksit' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
            'Ecom_Payment_Card_ExpDate_Month' => $this->formattedMonth($this->paravan->getCard()->getMonth()),
            'Ecom_Payment_Card_ExpDate_Year' => $this->formattedYear($this->paravan->getCard()->getYear()),
            'cardType' => 1,
            'islemtipi' => NestpayAbstract::TYPE_AUTH,
        ];
    }
}