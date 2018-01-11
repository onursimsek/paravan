<?php

namespace Paravan\Gateway;

use Paravan\Request;
use Paravan\RequestBuilder\Gvp\PayRequestBuilder;
use Paravan\RequestBuilder\Gvp\PreAuthRequestBuilder;
use Paravan\ResponseParser\Gvp\CallbackParser;
use Paravan\ResponseParser\Gvp\PayResponseParser;
use Paravan\ResponseParser\Gvp\PreAuthResponseParser;

abstract class GvpAbstract extends GatewayAbstract implements GatewayInterface
{
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
}