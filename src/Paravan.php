<?php

namespace Paravan;

use Paravan\Component\Card;
use Paravan\Component\Customer;
use Paravan\Component\Order;
use Paravan\Component\Transaction;
use Paravan\Configuration\ConfigurationAbstract;
use Paravan\Exception\GatewayException;
use Paravan\Gateway\GatewayInterface;
use Paravan\ResponseParser\ResponseParserInterface;

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

    /**
     * @var GatewayInterface
     */
    protected $gateway;

    /**
     * Paravan constructor.
     * @param ConfigurationAbstract $configuration
     * @throws GatewayException
     */
    public function __construct(ConfigurationAbstract $configuration)
    {
        $this->configuration = $configuration;

        $classname = '\\Paravan\\Gateway\\' . $this->configuration->getGateway();
        if (!class_exists($classname)) {
            throw new GatewayException('');
        }

        $this->gateway = new $classname($this);
    }

    /**
     * @return ConfigurationAbstract
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param $email
     * @param $ip
     * @return $this
     */
    public function setCustomer($email, $ip)
    {
        $this->customer = new Customer($email, $ip);

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param $cardNumber
     * @param $month
     * @param $year
     * @param $cvv
     * @return $this
     */
    public function setCard($cardNumber, $month, $year, $cvv)
    {
        $this->card = new Card($cardNumber, $month, $year, $cvv);

        return $this;
    }

    /**
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param $id
     * @param $amount
     * @param $installment
     * @return $this
     */
    public function setOrder($id, $amount, $installment)
    {
        $this->order = new Order($id, $amount, $installment);

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param $authenticationCode
     * @param $eci
     * @param $txn
     * @param $md
     * @return $this
     */
    public function setTransaction($authenticationCode, $eci, $txn, $md)
    {
        $this->transaction = new Transaction($authenticationCode, $eci, $txn, $md);

        return $this;
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    public function preAuth()
    {
        return $this->gateway->preAuth(new Request());
    }

    /**
     * @return ResponseParserInterface
     */
    public function pay()
    {
        return $this->gateway->pay(new Request());
    }
}