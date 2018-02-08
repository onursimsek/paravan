<?php

namespace Paravan\Gateway;

use Paravan\Configuration\ConfigurationAbstract;
use Paravan\Paravan;

abstract class GatewayAbstract
{
    /**
     * @var Paravan
     */
    protected $paravan;

    /**
     * @var ConfigurationAbstract
     */
    protected $configuration;

    /**
     * @var string
     */
    protected $preAuthUrl;

    /**
     * @var string
     */
    protected $provisionUrl;

    /**
     * @var string
     */
    protected $queryingUrl;

    public function __construct(Paravan $paravan)
    {
        $this->paravan = $paravan;
        $this->configuration = $this->paravan->getConfiguration();
    }

    public function getParavan(): Paravan
    {
        return $this->paravan;
    }
}