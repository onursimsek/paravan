<?php

namespace Paravan\ResponseParser;

use Paravan\Configuration\ConfigurationAbstract;

class GvpCallbackParser implements CallbackParserInterface
{
    /**
     * @var ConfigurationAbstract
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $params;

    public function __construct(ConfigurationAbstract $configuration, array $params)
    {
        $this->configuration = $configuration;
        $this->params = $params;
    }

    public function getErrorMessage(): string
    {
        return $this->params[''];
    }

    public function getErrorCode(): string
    {
        return $this->params[''];
    }

    public function isValid(): bool
    {
        return $this->isParameterValid() || $this->isRequestValid();
    }

    private function isParameterValid(): bool
    {
        switch ($this->params['mdStatus']) {
            case 1:
            case 2:
            case 3:
            case 4:
                return true;
                break;
        }

        return false;
    }

    private function isRequestValid(): bool
    {
        $paramsString = '';
        foreach (explode(':', $this->params['hashparams']) as $param) {
            $paramsString .= $this->params[strtolower($param)] ?: '';
        }

        $hash = base64_encode(pack('H*', sha1($paramsString . $this->configuration->getStoreKey())));

        if ($this->params['hash'] == $hash) {
            return true;
        }

        return false;
    }
}