<?php

namespace Paravan\RequestBuilder;

class NestpayRequestBuilder extends RequestBuilder
{
    use XmlBuilder;

    /**
     * Satış
     */
    const TYPE_AUTH = 'Auth';

    /**
     * Ön doğrulama
     */
    const TYPE_PRE_AUTH = 'PreAuth';

    public function preAuth()
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
            'islemtipi' => self::TYPE_AUTH,
        ];
    }

    protected function hashDataForPreAuth()
    {
        $string = $this->configuration->getMerchantId() .
            $this->paravan->getOrder()->getId() .
            $this->formattedAmount($this->paravan->getOrder()->getAmount()) .
            $this->configuration->getSuccessUrl() .
            $this->configuration->getErrorUrl() .
            $this->configuration->getRnd() .
            $this->configuration->getStoreKey();

        return base64_encode(pack('H*', sha1($string)));
    }

    public function pay()
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
            'Type' => self::TYPE_AUTH,
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

    protected function hashDataForPay()
    {
        // TODO: Implement hashDataForPay() method.
    }

    protected function formattedYear($year)
    {
        return \DateTime::createFromFormat('Y', $year)->format('y');
    }
}