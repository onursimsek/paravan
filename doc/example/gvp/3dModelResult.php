<?php

$settings = [];

if (!in_array($_POST['md_status'], [1, 2, 3, 4])) {
    throw new \Paravan\Exception\PreAuthException();
}

$paravan = new \Paravan\Paravan($settings);
$paravan->setCustomer('posta@onursimsek.com', $_SERVER['REMOTE_ADDR'])
    ->setOrder($_POST['oid'], 1.00, $_POST['txninstallmentcount'])
    ->setTransaction(
        $_POST['cavv'],
        $_POST['eci'],
        $_POST['xid'],
        $_POST['md']
    );

$response = $paravan->pay();

if (!$response->isSuccessful()) {
    throw new \Paravan\Exception\PaymentException();
}

echo 'Ödeme başarılı';