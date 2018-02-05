<?php

namespace Paravan\RequestBuilder\Nestpay;

use Paravan\RequestBuilder\NestpayRequestBuilder;
use Paravan\RequestBuilder\XmlBuilder;

class StatusRequestBuilder extends NestpayRequestBuilder
{
    use XmlBuilder;

    public function status()
    {
        return [
            'data' => $this->array2Xml(new \SimpleXMLElement('<CC5Request/>'), [
                'Name' => $this->configuration->getProvisionUser(),
                'Password' => $this->configuration->getProvisionPassword(),
                'ClientId' => $this->configuration->getMerchantId(),
                'OrderId' => $this->paravan->getOrder()->getId(),
                'Mode' => 'P',
                'Extra' => [
                    'ORDERSTATUS' => 'SOR'
                ],
            ])->asXML(),
        ];
    }
}