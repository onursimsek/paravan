<?php

namespace Paravan\Gateway;

class Akbank extends NestpayAbstract
{
    protected $preAuthUrl = 'https://www.sanalakpos.com/fim/est3Dgate';

    protected $provisionUrl = 'https://www.sanalakpos.com/fim/api';
}