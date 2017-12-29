<?php

namespace Paravan\RequestBuilder;

class GvpRequestBuilder extends RequestBuilder
{
    use XmlBuilder;

    public function preAuth()
    {
        return [
            'gateway' => $this->configuration->getGateway(),
            'mode' => $this->configuration->getMode(),
            'apiversion' => $this->configuration->getVersion(),
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
            'terminalid' => $this->configuration->getTerminalId(),
            'successurl' => $this->configuration->getSuccessUrl(),
            'errorurl' => $this->configuration->getErrorUrl(),
            'customeremailaddress' => $this->paravan->getCustomer()->getEmail(),
            'customeripaddress' => $this->paravan->getCustomer()->getIp(),
            'secure3dsecuritylevel' => $this->configuration->getSecurityLevel(),
            'secure3dhash' => $this->hashDataForPreAuth(),
        ];
    }

    protected function hashDataForPreAuth()
    {
        $security = strtoupper(sha1($this->configuration->getProvisionPassword() . $this->formattedTerminalId($this->configuration->getTerminalId())));

        return strtoupper(sha1($this->configuration->getTerminalId() . $this->paravan->getOrder()->getId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $this->configuration->getSuccessUrl() . $this->configuration->getErrorUrl() . $this->configuration->getType() . $this->formattedInstallment($this->paravan->getOrder()->getInstallment()) . $this->configuration->getStoreKey() . $security));
    }

    public function pay()
    {
        $data = [
            'Mode' => $this->configuration->getMode(),
            'Version' => $this->configuration->getVersion(),
            'ChannelCode' => '',
            'Terminal' => [
                'ProvUserID' => $this->configuration->getProvisionUser(),
                'HashData' => $this->hashDataForPay(),
                'UserID' => $this->configuration->getTerminalUserId(),
                'ID' => $this->configuration->getTerminalId(),
                'MerchantID' => $this->configuration->getMerchantId(),
            ],
            'Customer' => [
                'IPAddress' => $this->paravan->getCustomer()->getIp(),
                'EmailAddress' => $this->paravan->getCustomer()->getEmail(),
            ],
            'Card' => [
                'Number' => '',
                'ExpireDate' => '',
                'CVV2' => '',
            ],
            'Order' => [
                'OrderID' => $this->paravan->getOrder()->getId(),
                'GroupID' => '',
                'AddressList' => [
                    'Address' => [
                        'Type' => 'B',
                        'Name' => '',
                        'LastName' => '',
                        'Company' => '',
                        'Text' => '',
                        'District' => '',
                        'City' => '',
                        'PostalCode' => '',
                        'Country' => '',
                        'PhoneNumber' => '',
                    ],
                ]
            ],
            'Transaction' => [
                'Type' => $this->configuration->getType(),
                'InstallmentCnt' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
                'Amount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
                'CurrencyCode' => $this->configuration->getCurrencyCode(),
                'CardholderPresentCode' => $this->configuration->getCardholderPresentCode(),
                'MotoInd' => $this->configuration->getMotoInd(),
                'Secure3D' => [
                    'AuthenticationCode' => $this->paravan->getTransaction()->getAuthenticationCode(),
                    'SecurityLevel' => $this->paravan->getTransaction()->getEci(),
                    'TxnID' => $this->paravan->getTransaction()->getTxn(),
                    'Md' => $this->paravan->getTransaction()->getMd(),
                ],
            ],
        ];

        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<GVPSRequest/>'), $data)->asXML(),
        ];
    }

    protected function hashDataForPay()
    {
        $secureData = strtoupper(sha1($this->configuration->getProvisionPassword() . $this->formattedTerminalId($this->configuration->getTerminalId())));

        return strtoupper(sha1($this->paravan->getOrder()->getId() . $this->configuration->getTerminalId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $secureData));
    }

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
}