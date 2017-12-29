<?php

require __DIR__ . '/../../../vendor/autoload.php';

$config = [
    'gateway' => \Paravan\Component\Bank::FINANSBANK,
    'merchant_id' => '601412834',
    'provision_user' => 'QNB_API',
    'provision_password' => '0di6Qx5KYd',
    'mode' => 'P',
    'cardholder_present_code' => 13,
    'currency_code' => 949,
    'lang' => 'tr',
    'error_url' => 'https://example.com/payment/fail',
    'success_url' => 'https://example.com/payment/success',
    'store_key' => 'APzC4QvTar',
    'security_level' => '3D_PAY',
];

$configuration = new \Paravan\Configuration\NestpayConfiguration($config);

$paravan = new \Paravan\Paravan($configuration);
$response = $paravan->setCustomer('posta@onursimsek.com', '127.0.0.1')
    ->setCard('0123456789012345', '2', '2017', '123')
    ->setOrder(uniqid(), 1.00, 1)
    ->preAuth();

print_r($response->getRawResponse());