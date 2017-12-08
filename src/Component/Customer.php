<?php

namespace Paravan\Components;

class Customer
{
    private $email;
    private $ip;

    /**
     * Customer constructor.
     * @param $email
     * @param $ip
     */
    public function __construct($email, $ip)
    {
        $this->email = $email;
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }
}