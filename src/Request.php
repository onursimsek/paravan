<?php

namespace Paravan;

use GuzzleHttp\Client;

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

    public function send(string $endpoint, array $params)
    {
        $request = $this->client->request('POST', $endpoint, [
            'form_params' => $params,
        ]);

        return $request->getBody()->getContents();
    }
}