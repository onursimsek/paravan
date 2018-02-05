<?php

namespace Paravan\RequestBuilder\Nestpay;

use Paravan\Gateway\NestpayAbstract;
use Paravan\RequestBuilder\NestpayRequestBuilder;
use Paravan\RequestBuilder\XmlBuilder;

class PayRequestBuilder extends NestpayRequestBuilder
{
    use XmlBuilder;

    public function pay(): array
    {
        switch (mb_convert_case($this->configuration->getSecurityLevel(), MB_CASE_UPPER)) {
            case NestpayAbstract::SECURITY_LEVEL_3D_PAY:
            default:
                return $this->securityLevel3DPay();
                break;
        }
    }

    protected function securityLevel3DPay(): array
    {
        $data = [
            'Name' => $this->configuration->getProvisionUser(),
            'Password' => $this->configuration->getProvisionPassword(),
            'ClientId' => $this->configuration->getMerchantId(),
            'OrderId' => $this->paravan->getOrder()->getId(),
            'Mode' => 'P',
            'Extra' => [
                'ORDERSTATUS' => 'SOR'
            ],
        ];

        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<CC5Request/>'), $data)->asXML(),
        ];
    }

    protected function securityLevel3D(): array
    {
        $data = [
            'Name' => $this->configuration->getProvisionUser(),
            'Password' => $this->configuration->getProvisionPassword(),
            'ClientId' => $this->configuration->getMerchantId(),
            'IPAddress' => $this->paravan->getCustomer()->getIp(),
            'Email' => $this->paravan->getCustomer()->getEmail(),
            'Mode' => $this->configuration->getMode(),
            'OrderId' => $this->paravan->getOrder()->getId(),
            'GroupId' => '',
            'TransId' => '',
            'UserId' => '',
            'Type' => NestpayAbstract::TYPE_AUTH,
            'Number' => $this->paravan->getTransaction()->getMd(),
            'Expires' => '',
            'Cvv2Val' => '',
            'Total' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
            'Currency' => $this->configuration->getCurrencyCode(),
            'Taksit' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
            'PayerTxnId' => $this->paravan->getTransaction()->getTxn(),
            'PayerSecurityLevel' => $this->paravan->getTransaction()->getEci(),
            'PayerAuthenticationCode' => $this->paravan->getTransaction()->getAuthenticationCode(),
            'CardholderPresentCode' => $this->configuration->getCardHolderPresentCode(),
            'BillTo' => [
                'Name' => '',
                'Street1' => '',
                'Street2' => '',
                'Street3' => '',
                'City' => '',
                'StateProv' => '',
                'PostalCode' => '',
                'Country' => '',
                'Company' => '',
                'TelVoice' => '',
            ],
            'ShipTo' => [
                'Name' => '',
                'Street1' => '',
                'Street2' => '',
                'Street3' => '',
                'City' => '',
                'StateProv' => '',
                'PostalCode' => '',
                'Country' => '',
            ],
            'Extra' => '',
        ];

        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<CC5Request/>'), $data)->asXML(),
        ];
    }
}