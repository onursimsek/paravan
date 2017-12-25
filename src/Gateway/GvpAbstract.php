<?php

namespace Paravan\Gateway;

use Paravan\Request;
use Paravan\RequestBuilder\GvpRequestBuilder;
use Paravan\ResponseParser\GvpPayResponseParser;
use Paravan\ResponseParser\GvpPreAuthResponseParser;

abstract class GvpAbstract extends GatewayAbstract
{
    /**
     * @param Request $request
     * @return GvpPreAuthResponseParser
     */
    public function preAuth(Request $request)
    {
        return new GvpPreAuthResponseParser($request->send($this->preAuthUrl, (new GvpRequestBuilder($this))->preAuth()));
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