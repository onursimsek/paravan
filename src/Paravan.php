<?php
/**
 * This file is part of the onursimsek/paravan library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Onur Şimşek <posta@onursimsek.com>
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 * @link https://github.com/onursimsek/paravan GitHub
 */

namespace Paravan;

use Paravan\Component\Card;
use Paravan\Component\Customer;
use Paravan\Component\Order;
use Paravan\Component\Transaction;
use Paravan\Configuration\ConfigurationAbstract;
use Paravan\Exception\GatewayException;
use Paravan\Gateway\GatewayInterface;
use Paravan\ResponseParser\PayResponseParserInterface;
use Paravan\ResponseParser\PreAuthResponseParserInterface;

/**
 * Payment system for Turkish Banks
 *
 * Supported banks
 *  - Garanti 3D (Gvp)
 *  - Finansbank 3D (Nestpay)
 *
 * @package Paravan
 */
class Paravan
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Card
     */
    protected $card;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var Transaction
     */
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
    public function getConfiguration(): ConfigurationAbstract
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
    public function getCustomer(): Customer
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
    public function getCard(): Card
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
    public function getOrder(): Order
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
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @return PreAuthResponseParserInterface
     */
    public function preAuth(): PreAuthResponseParserInterface
    {
        return $this->gateway->preAuth(new Request());
    }

    /**
     * @return PayResponseParserInterface
     */
    public function pay(): PayResponseParserInterface
    {
        return $this->gateway->pay(new Request());
    }
}