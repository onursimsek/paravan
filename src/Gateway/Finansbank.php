<?php

namespace Paravan\Gateway;

class Finansbank extends NestpayAbstract
{
    protected $preAuthUrl = 'https://www.fbwebpos.com/fim/est3Dgate';

    protected $provisionUrl = 'https://www.fbwebpos.com/fim/api';

    protected $queryingUrl = 'https://www.fbwebpos.com/fim/cc5ApiServer';
}