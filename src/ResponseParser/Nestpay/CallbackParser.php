<?php

namespace Paravan\ResponseParser\Nestpay;

use Paravan\Configuration\ConfigurationAbstract;
use Paravan\ResponseParser\CallbackParserInterface;

class CallbackParser implements CallbackParserInterface
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
        return $this->params['mdErrorMsg'];
    }

    public function getErrorCode(): string
    {
        return $this->params['ProcReturnCode'];
    }

    public function isValid(): bool
    {
        return $this->isParameterValid() && $this->isRequestValid();
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
        $paramsValue = '';
        $i = $j = 0;
        while ($i < strlen($this->params['HASHPARAMS'])) {
            $j = strpos($this->params['HASHPARAMS'], ':', $i);
            $paramsValue .= $this->params[substr($this->params['HASHPARAMS'], $i, $j - $i)] ?: '';
            $i = $j + 1;
        }

        $hash = base64_encode(pack('H*', sha1($paramsValue . $this->configuration->getStoreKey())));

        return $paramsValue == $this->params['HASHPARAMSVAL'] && $this->params['HASH'] == $hash;
    }
}