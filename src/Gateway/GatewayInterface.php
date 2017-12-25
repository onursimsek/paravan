<?php

namespace Paravan\Gateway;

use Paravan\Paravan;
use Paravan\Request;

interface GatewayInterface
{
    public function getParavan(): Paravan;

    public function preAuth(Request $request);

    public function pay(Request $request);
}