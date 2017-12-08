<?php

namespace Paravan\Gateway;

use Paravan\Component\CardInterface;
use Paravan\Component\CustomerInterface;
use Paravan\Component\OrderInterface;
use Paravan\Request;

class Garanti implements GatewayInterface, GvpInterface
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @var string
     */
    private $preAuthUrl = 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine';

    /**
     * @var string
     */
    private $provisionUrl = 'https://sanalposprov.garanti.com.tr/VPServlet';

    /**
     * @var OrderInterface
     */
    private $order;

    /**
     * @var CustomerInterface
     */
    private $customer;

    /**
     * @var CardInterface
     */
    private $card;

    private $transaction;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

    public function setCard(CardInterface $card)
    {
        $this->card = $card;
        return $this;
    }

    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    public function preAuth(Request $request)
    {
        return $request->send($this->preAuthUrl, []);
    }

    public function pay(Request $request)
    {
        return $request->send($this->provisionUrl, []);
    }

    private function buildPreAuthRequest()
    {

    }

    private function getPreAuthHashData()
    {
        $security = strtoupper(sha1($this->provisionPassword . str_pad($this->terminalId, 9, 0, STR_PAD_LEFT)));
        $this->securityData = strtoupper(sha1($this->terminalId . $this->orderId . $this->amount . $this->successUrl . $this->errorUrl . $this->type . $this->installment . $this->storeKey . $security));

        return $this->securityData;
    }

    private function getProvisionHashData()
    {
        return strtoupper(sha1($this->orderId . $this->terminalId . $this->amount . strtoupper(sha1($this->provisionPassword . str_pad($this->terminalId, 9, 0, STR_PAD_LEFT)))));
    }
}