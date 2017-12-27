<?php

namespace Paravan\Gateway;

use Paravan\Request;
use Paravan\RequestBuilder\NestpayRequestBuilder;
use Paravan\ResponseParser\NestpayCallbackParser;
use Paravan\ResponseParser\NestpayPreAuthResponseParser;

abstract class NestpayAbstract extends GatewayAbstract implements GatewayInterface
{
    public function preAuth(Request $request)
    {
        return new NestpayPreAuthResponseParser($request->send($this->preAuthUrl, (new NestpayRequestBuilder($this))->preAuth()));
    }

    public function callbackValidation(array $params)
    {
        return new NestpayCallbackParser($this->configuration, $params);
    }

    public function pay(Request $request)
    {
        return $request->send($this->provisionUrl, (new NestpayRequestBuilder($this))->pay());
    }
}