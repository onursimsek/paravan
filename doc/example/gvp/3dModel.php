<?php

$settings = [];

$configuration = new \Paravan\Configuration\Configuration('gvp');

$paravan = new \Paravan\Paravan($configuration);

$paravan->setCustomer('posta@onursimsek.com', $_SERVER['REMOTE_ADDR'])
    ->setCard('0123456789012345', '2', '2017', '123')
    ->setOrder(uniqid(), 1.00, 1);

echo $paravan->preAuth();
