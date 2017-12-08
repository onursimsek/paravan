<?php

namespace Paravan\Configuration;

class Configuration extends ConfigurationAbstract
{
    private $gateway;

    public function __construct($gateway)
    {
        $this->gateway = $gateway;
    }
}