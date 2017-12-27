<?php

namespace Paravan\Gateway;

class Garanti extends GvpAbstract
{
    protected $preAuthUrl = 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine';

    protected $provisionUrl = 'https://sanalposprov.garanti.com.tr/VPServlet';
}