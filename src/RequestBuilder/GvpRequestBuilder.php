<?php

namespace Paravan\RequestBuilder;

class GvpRequestBuilder extends RequestBuilder
{
    use XmlBuilder;

    public function preAuth()
    {
        return [
            'mode' => $this->paravan->getConfiguration()->getMode(),
            'apiversion' => $this->paravan->getConfiguration()->getVersion(),
            'terminalprovuserid' => $this->paravan->getConfiguration()->getProvisionUser(),
            'terminaluserid' => $this->paravan->getConfiguration()->getTerminalUserId(),
            'terminalmerchantid' => $this->paravan->getConfiguration()->getMerchantId(),
            'txntype' => $this->paravan->getConfiguration()->getType(),
            'cardnumber' => $this->paravan->getCard()->getCardNumber(),
            'cardexpiredatemonth' => $this->formattedMonth($this->paravan->getCard()->getMonth()),
            'cardexpiredateyear' => $this->paravan->getCard()->getYear(),
            'cardcvv2' => $this->paravan->getCard()->getCvv(),
            'txnamount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
            'txncurrencycode' => $this->paravan->getConfiguration()->getCurrencyCode(),
            'txninstallmentcount' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
            'orderid' => $this->paravan->getOrder()->getId(),
            'terminalid' => $this->paravan->getConfiguration()->getTerminalId(),
            'successurl' => $this->paravan->getConfiguration()->getSuccessUrl(),
            'errorurl' => $this->paravan->getConfiguration()->getErrorUrl(),
            'customeremailaddress' => $this->paravan->getCustomer()->getEmail(),
            'customeripaddress' => $this->paravan->getCustomer()->getIp(),
            'secure3dsecuritylevel' => $this->paravan->getConfiguration()->getSecurityLevel(),
            'secure3dhash' => $this->hashDataForPreAuth(),
        ];
    }

    protected function hashDataForPreAuth()
    {
        $configuration = $this->paravan->getConfiguration();
        $security = strtoupper(sha1($configuration->getProvisionPassword() . str_pad($configuration->getTerminalId(), 9, 0, STR_PAD_LEFT)));

        return strtoupper(sha1($configuration->getTerminalId() . $this->paravan->getOrder()->getId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $configuration->getSuccessUrl() . $configuration->getErrorUrl() . $configuration->getType() . $this->formattedInstallment($this->paravan->getOrder()->getInstallment()) . $configuration->getStoreKey() . $security));
    }

    public function pay()
    {
        $data = [
            'Mode' => $this->paravan->getConfiguration()->getMode(),
            'Version' => $this->paravan->getConfiguration()->getVersion(),
            'ChannelCode' => '',
            'Terminal' => [
                'ProvUserID' => $this->paravan->getConfiguration()->getProvisionUser(),
                'HashData' => $this->hashDataForPay(),
                'UserID' => $this->paravan->getConfiguration()->getTerminalUserId(),
                'ID' => $this->paravan->getConfiguration()->getTerminalId(),
                'MerchantID' => $this->paravan->getConfiguration()->getMerchantId(),
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
                'Type' => $this->paravan->getConfiguration()->getType(),
                'InstallmentCnt' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
                'Amount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
                'CurrencyCode' => $this->paravan->getConfiguration()->getCurrencyCode(),
                'CardholderPresentCode' => $this->paravan->getConfiguration()->getCardholderPresentCode(),
                'MotoInd' => $this->paravan->getConfiguration()->getMotoInd(),
                'Secure3D' => [
                    'AuthenticationCode' => $this->paravan->getTransaction()->getAuthenticationCode(),
                    'SecurityLevel' => $this->paravan->getTransaction()->getEci(),
                    'TxnID' => $this->paravan->getTransaction()->getTxn(),
                    'Md' => $this->paravan->getTransaction()->getMd(),
                ],
            ],
        ];

        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<GVPSRequest/>'), $data),
        ];
    }

    protected function hashDataForPay()
    {
        $secureData = strtoupper(sha1($this->paravan->getConfiguration()->getProvisionPassword() . $this->formattedTerminalId($this->paravan->getConfiguration()->getTerminalId())));

        return strtoupper(sha1($this->paravan->getOrder()->getId() . $this->paravan->getConfiguration()->getTerminalId() . $this->formattedAmount($this->paravan->getOrder()->getAmount()) . $secureData));
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