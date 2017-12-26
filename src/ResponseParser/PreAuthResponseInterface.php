<?php

namespace Paravan\ResponseParser;

interface PreAuthResponseInterface extends ResponseParserInterface
{
    public function isRedirect(): bool;
}