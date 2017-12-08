<?php

namespace Paravan\Gateway;

use Paravan\Component\CardInterface;
use Paravan\Component\CustomerInterface;
use Paravan\Component\OrderInterface;

interface GatewayInterface
{
    public function setOrder(OrderInterface $order);

    public function setCard(CardInterface $card);

    public function setCustomer(CustomerInterface $customer);
}