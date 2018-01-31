<?php

namespace Paravan\RequestBuilder\Gvp;

use Paravan\Gateway\GvpAbstract;
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
        switch (mb_convert_case($this->configuration->getSecurityLevel(), MB_CASE_UPPER)) {
            case GvpAbstract::SECURITY_LEVEL_CUSTUM_PAY:
                // Ödeme zaten yapılmıştır kontrol edilir
                return $this->securityLevelCustomPay();
                break;
            case GvpAbstract::SECURITY_LEVEL_3D:
            case GvpAbstract::SECURITY_LEVEL_3D_PAY:
            case GvpAbstract::SECURITY_LEVEL_3D_FULL:
            case GvpAbstract::SECURITY_LEVEL_3D_HALF:
            default:
                return $this->securityLevel3D();
                break;
        }
    }

    /**
     * @return array
     */
    public function securityLevel3D(): array
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

    /**
     * @return array
     */
    public function securityLevelCustomPay(): array
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
                        'Type' => 'S',
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
                'Type' => 'orderinq',
                'InstallmentCnt' => $this->formattedInstallment($this->paravan->getOrder()->getInstallment()),
                'Amount' => $this->formattedAmount($this->paravan->getOrder()->getAmount()),
                'CurrencyCode' => $this->configuration->getCurrencyCode(),
                'CardholderPresentCode' => $this->configuration->getCardholderPresentCode(),
                'MotoInd' => $this->configuration->getMotoInd(),
                'Secure3D' => [
                    'AuthenticationCode' => '',
                    'SecurityLevel' => '',
                    'TxnID' => '',
                    'Md' => '',
                ],
            ],
        ];

        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<GVPSRequest/>'), $data)->asXML(),
        ];
    }
}