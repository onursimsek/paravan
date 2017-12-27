<?php

require __DIR__ . '/../../../vendor/autoload.php';

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
    'provision_user' => 'PROVAUT',
    'provision_password' => 'XXXXXXXXXXX',
    'store_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    'success_url' => 'https://example.com/payment/success',
    'error_url' => 'https://example.com/payment/fail',
    'security_level' => '3D',
];

$configuration = new \Paravan\Configuration\GvpConfiguration($config);

$paravan = new \Paravan\Paravan($configuration);

$response = $paravan->setCustomer('posta@onursimsek.com', '127.0.0.1')
    ->setCard('0123456789012345', '2', '2017', '123')
    ->setOrder(uniqid(), 1.00, 1)
    ->preAuth();

print_r($response->getRawResponse());