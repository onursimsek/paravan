<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

interface ResponseParserInterface
{
    public function __construct(ResponseInterface $response);

    public function getRawResponse(): string;
}