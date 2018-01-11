<?php

namespace Paravan\RequestBuilder\Gvp;

use Paravan\RequestBuilder\GvpRequestBuilder;
use Paravan\RequestBuilder\XmlBuilder;

class PayRequestBuilder extends GvpRequestBuilder
{
    use XmlBuilder;

    /**
     * @return array
     */
    public function pay(): array
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
}