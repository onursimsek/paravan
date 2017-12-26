<?php

namespace Paravan;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Request
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'defaults' => [
                'verify' => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ],
        ]);
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(string $endpoint, array $params): ResponseInterface
    {
        $request = $this->client->request('POST', $endpoint, [
            'form_params' => $params,
        ]);

        return $request;
    }
}