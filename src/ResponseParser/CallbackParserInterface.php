<?php

namespace Paravan\ResponseParser;

use Paravan\Configuration\ConfigurationAbstract;

interface CallbackParserInterface
{
    public function __construct(ConfigurationAbstract $configuration, array $params);

    public function getErrorMessage(): string;

    public function getErrorCode(): string;

    public function isValid(): bool;
}