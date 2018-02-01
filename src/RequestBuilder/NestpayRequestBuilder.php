<?php

namespace Paravan\RequestBuilder;

abstract class NestpayRequestBuilder extends RequestBuilder
{
    protected function formattedYear($year)
    {
        return \DateTime::createFromFormat('Y', $year)->format('y');
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

    protected function hashDataForPay()
    {

    }
}