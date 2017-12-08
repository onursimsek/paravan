<?php

namespace Paravan\Component;

interface CardInterface
{
    public function getCardNumber();

    public function getMonth();

    public function getYear();

    public function getCvv();
}