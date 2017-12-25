<?php

namespace Paravan\Component;

class Card implements CardInterface
{
    private $cardNumber;
    private $month;
    private $year;
    private $cvv;

    /**
     * Card constructor.
     * @param $cardNumber
     * @param $month
     * @param $year
     * @param $cvv
     */
    public function __construct($cardNumber, $month, $year, $cvv)
    {
        $this->cardNumber = $cardNumber;
        $this->month = $month;
        $this->year = $year;
        $this->cvv = $cvv;
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getCvv()
    {
        return $this->cvv;
    }
}