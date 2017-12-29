# Paravan

Türkiye bankaları için ödeme işlemlerini yapan bir php kütüphanesi

## Gereksinimler

* `curl`

## Kurulum

```shell
composer require onursimsek/paravan
```

## Kullanım

### Garanti 3D ödeme ayarları

```php
$config = new \Paravan\Configuration\GvpConfiguration([
    'gateway' => \Paravan\Component\Bank::GARANTI,
    'mode' => 'PROD',
    'api_version' => 'v0.01',
    'type' => 'sales',
    'currency_code' => '949',
    'cardholder_present_code' => '13',
    'moto_ind' => 'N',
    'merchant_id' => 'XXXXXXX',
    'terminal_id' => 'XXXXXXX',
    'terminal_user_id' => 'XXXXXXX',
    'provision_user' => 'PROVAUT',
    'provision_password' => 'XXXXXXXXXXX',
    'store_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    'success_url' => 'https://example.com/payment/success',
    'error_url' => 'https://example.com/payment/fail',
    'security_level' => '3D',
]);
```


### Ön doğrulama isteği (3dmodel.php)

```php
$paravan = new \Paravan\Paravan($config);
$response = $paravan->setCustomer('user@email.com', $_SERVER['REMOTE_ADDR'])
    ->setCard('0123456789012345', '2', '2020', '123')
    ->setOrder(uniqid(), 1.00, 1)
    ->preAuth();
    
// Yönlendirme yapmak için
$response->getRawResponse();
```

### Provizyon isteği (3dmodel_result.php)

```php
$paravan = new \Paravan\Paravan($config);

// Bankadan dönen isteğin doğrulanması
$validator = $paravan->callbackValidation($_POST);
if (!$validator->isValid()) {
    throw new Exception($validator->getErrorMessage());
}

// Tutarı çekme işlemi
$response = $paravan->setCustomer('user@email.com', $_SERVER['REMOTE_ADDR'])
    ->setOrder($_POST['oid'], 1.00, $_POST['txninstallmentcount'])
    ->setTransaction(
        $_POST['cavv'],
        $_POST['eci'],
        $_POST['xid'],
        $_POST['md']
    )
    ->pay();

if (!$response->isSuccess()) {
  throw new Exception($pay->getErrorMessage());
}

$response->getRawResponse();
```

## Yapılacaklar

* Finansbank 3d (nestpay)
* Akbank 3d (nestpay)
* Yapı Kredi 3d (posnet)

## Lisans

[GNU General Public License v3.0](https://github.com/onursimsek/paravan/blob/master/LICENSE)
