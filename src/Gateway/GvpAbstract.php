<?php

namespace Paravan\Gateway;

use Paravan\Request;
use Paravan\RequestBuilder\GvpRequestBuilder;
use Paravan\ResponseParser\GvpCallbackParser;
use Paravan\ResponseParser\GvpPayResponseParser;
use Paravan\ResponseParser\GvpPreAuthResponseParser;

abstract class GvpAbstract extends GatewayAbstract implements GatewayInterface
{
    /**
     * @param Request $request
     * @return GvpPreAuthResponseParser
     */
    public function preAuth(Request $request)
    {
        return new GvpPreAuthResponseParser($request->send($this->preAuthUrl, (new GvpRequestBuilder($this))->preAuth()));
    }

    public function callbackValidation(array $params)
    {
        return new GvpCallbackParser($this->configuration, $params);
    }

    /**
     * @param Request $request
     * @return GvpPayResponseParser
     */
    public function pay(Request $request)
    {
        return new GvpPayResponseParser($request->send($this->provisionUrl, (new GvpRequestBuilder($this))->pay()));
    }
}