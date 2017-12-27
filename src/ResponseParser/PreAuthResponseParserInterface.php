<?php

namespace Paravan\ResponseParser;

interface PreAuthResponseParserInterface extends ResponseParserInterface
{
    public function isRedirect(): bool;
}