<?php

namespace Paravan\Configuration;

class GvpConfiguration extends ConfigurationAbstract
{
    private $terminalId;

    private $provisionUser;

    private $provisionPassword;

    private $mode;

    /**
     * @return mixed
     */
    public function getTerminalId()
    {
        return $this->terminalId;
    }

    /**
     * @param mixed $terminalId
     */
    public function setTerminalId($terminalId): void
    {
        $this->terminalId = $terminalId;
    }

    /**
     * @return mixed
     */
    public function getProvisionUser()
    {
        return $this->provisionUser;
    }

    /**
     * @param mixed $provisionUser
     */
    public function setProvisionUser($provisionUser): void
    {
        $this->provisionUser = $provisionUser;
    }

    /**
     * @return mixed
     */
    public function getProvisionPassword()
    {
        return $this->provisionPassword;
    }

    /**
     * @param mixed $provisionPassword
     */
    public function setProvisionPassword($provisionPassword): void
    {
        $this->provisionPassword = $provisionPassword;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode): void
    {
        $this->mode = $mode;
    }
}