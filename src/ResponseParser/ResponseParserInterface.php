<?php

namespace Paravan\ResponseParser;

use Psr\Http\Message\ResponseInterface;

interface ResponseParserInterface
{
    public function __construct(ResponseInterface $response);

    public function isSuccess(): bool;

    public function getErrorMessage(): string;

    public function getErrorCode(): string;

    public function getRawResponse(): string;
}