<?php

require __DIR__ . '/../../../vendor/autoload.php';

$settings = [];

if (!in_array($_POST['md_status'], [1, 2, 3, 4])) {
    throw new \Paravan\Exception\PreAuthException();
}

$config = [
    'gateway' => \Paravan\Component\Bank::GARANTI,
    'mode' => 'PROD',
    'api_version' => 'v0.01',
    'type' => 'sales',
    'currency_code' => '949',
    'cardholder_present_code' => '13',
    'moto_ind' => 'N',
    'merchant_id' => '1234567',
    'terminal_id' => '12345678',
    'terminal_user_id' => '1234567',
    'provision_user_id' => 'PROVAUT',
    'provision_password' => 'XXXXXXXXXXX',
    'store_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    'success_url' => 'https://example.com/payment/success',
    'error_url' => 'https://example.com/payment/fail',
    'security_level' => '3D',
];

$configuration = new \Paravan\Configuration\GvpConfiguration($config);

$paravan = new \Paravan\Paravan($configuration);
$paravan->setCustomer('posta@onursimsek.com', $_SERVER['REMOTE_ADDR'])
    ->setOrder($_POST['oid'], 1.00, $_POST['txninstallmentcount'])
    ->setTransaction(
        $_POST['cavv'],
        $_POST['eci'],
        $_POST['xid'],
        $_POST['md']
    );

$response = $paravan->pay();

if (!$response->isSuccess()) {
    throw new \Paravan\Exception\PaymentException();
}

echo 'Ödeme başarılı';