<?php

namespace Paravan\ResponseParser;

interface PayResponseParserInterface extends ResponseParserInterface
{
    public function isSuccess(): bool;

    public function getErrorMessage(): string;

    public function getErrorCode(): string;
}