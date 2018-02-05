<?php

namespace Paravan\Gateway;

use Paravan\Request;
use Paravan\RequestBuilder\Nestpay\PayRequestBuilder;
use Paravan\RequestBuilder\Nestpay\PreAuthRequestBuilder;
use Paravan\ResponseParser\Nestpay\CallbackParser;
use Paravan\ResponseParser\Nestpay\PayResponseParser;
use Paravan\ResponseParser\Nestpay\PreAuthResponseParser;

abstract class NestpayAbstract extends GatewayAbstract implements GatewayInterface
{
    /**
     * Satış
     */
    const TYPE_AUTH = 'Auth';

    /**
     * Ön doğrulama
     */
    const TYPE_PRE_AUTH = 'PreAuth';

    const SECURITY_LEVEL_3D_PAY = '3D_PAY';

    /**
     * @param Request $request
     * @return PreAuthResponseParser
     */
    public function preAuth(Request $request)
    {
        return new PreAuthResponseParser($request->send($this->preAuthUrl, (new PreAuthRequestBuilder($this))->preAuth()));
    }

    /**
     * @param array $params
     * @return CallbackParser
     */
    public function callbackValidation(array $params)
    {
        return new CallbackParser($this->configuration, $params);
    }

    /**
     * @param Request $request
     * @return PayResponseParser
     */
    public function pay(Request $request)
    {
        return new PayResponseParser($request->send($this->provisionUrl, (new PayRequestBuilder($this))->pay()));
    }

    public function status(Request $request)
    {

    }
}