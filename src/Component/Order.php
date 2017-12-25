<?php

namespace Paravan\Component;

class Order implements OrderInterface
{
    private $id;
    private $amount;
    private $installment;

    /**
     * Order constructor.
     * @param $id
     * @param $amount
     * @param $installment
     */
    public function __construct($id, $amount, $installment)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->installment = $installment;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getInstallment()
    {
        return $this->installment;
    }
}