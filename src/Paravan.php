<?php

namespace Paravan;

use Paravan\Component\Transaction;
use Paravan\Components\Card;
use Paravan\Components\Customer;
use Paravan\Components\Order;
use Paravan\Configuration\ConfigurationAbstract;
use Paravan\Exception\GatewayException;

class Paravan
{
    protected $customer;

    protected $card;

    protected $order;

    protected $transaction;

    /**
     * @var ConfigurationAbstract
     */
    private $configuration;

    public function __construct(ConfigurationAbstract $configuration)
    {
        $this->configuration = $configuration;
    }

    public function setCustomer($email, $ip)
    {
        $this->customer = new Customer($email, $ip);

        return $this;
    }

    public function setCard($cardNumber, $month, $year, $cvv)
    {
        $this->card = new Card($cardNumber, $month, $year, $cvv);

        return $this;
    }

    public function setOrder($id, $amount, $installment)
    {
        $this->order = new Order($id, $amount, $installment);

        return $this;
    }

    public function setTransaction($authenticationCode, $eci, $txn, $md)
    {
        $this->transaction = new Transaction($authenticationCode, $eci, $txn, $md);

        return $this;
    }

    public function preAuth()
    {
        $this->settings['gateway'] = mb_convert_case($this->settings['gateway'], MB_CASE_TITLE);
        if (!class_exists($this->settings['gateway'])) {
            throw new GatewayException();
        }

        $gateway = new $this->settings['gateway']($this->settings);
        $gateway->setCustomer($this->customer)
            ->setCard($this->card)
            ->setOrder($this->order)
            ->preAuth(new Request());
    }

    public function pay()
    {

    }
}