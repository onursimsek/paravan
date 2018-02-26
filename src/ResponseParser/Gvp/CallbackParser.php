<?php

namespace Paravan\ResponseParser\Gvp;

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

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->params['mderrormessage'];
    }

    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return $this->params['mdstatus'];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isParameterValid() && $this->isRequestValid();
    }

    /**
     * @return bool
     */
    private function isParameterValid(): bool
    {
        switch ($this->params['mdstatus']) {
            case 1:
            case 2:
            case 3:
            case 4:
                return true;
                break;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function isRequestValid(): bool
    {
        $paramsString = '';
        foreach (explode(':', $this->params['hashparams']) as $param) {
            $paramsString .= $this->params[strtolower($param)] ?: '';
        }

        $hash = base64_encode(pack('H*', sha1($paramsString . $this->configuration->getStoreKey())));

        return $this->params['hash'] == $hash;
    }
}