<?php

namespace Paravan\Component;

interface OrderInterface
{
    public function getId();

    public function getAmount();

    public function getInstallment();
}