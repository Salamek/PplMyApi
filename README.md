# Professional Parcel Logistic MyApi client in PHP

[![Build Status](https://travis-ci.org/Salamek/PplMyApi.svg?branch=master)](https://travis-ci.org/Salamek/PplMyApi)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=D8LQ4XTBLV3C4&lc=CZ&item_number=SalamekPplMyApi&currency_code=EUR)

Professional Parcel Logistic MyApi client in PHP


## Requirements

- PHP 5.4 or higher

## Installation

Install salamek/PplMyApi using  [Composer](http://getcomposer.org/)

```sh
$ composer require salamek/ppl-my-api
```

or if you want master branch code:

```sh
$ composer require salamek/ppl-my-api:dev-master
```

## Credentials

You must request MyAPI credentials from PPL IT, it is not same as klient.ppl.cz credentials!

## Usage

### Is API healthy

Check if PPL MyApi is in working shape

```php
$pplMyApi = new Salamek\PplMyApi\Api();
if ($pplMyApi->isHealthy())
{
    echo 'Healthy :)' . PHP_EOL;
}
else
{
    echo 'Ill :(' . PHP_EOL;
}
```

### Get API version

Returns version of PPL MyApi

```php
$pplMyApi = new Salamek\PplMyApi\Api();
echo $pplMyApi->getVersion() . PHP_EOL;
```

### Get parcel shops

Returns array of parcel shops filtered by `$code` and `$countryCode`

```php
$pplMyApi = new Salamek\PplMyApi\Api();
$result = $pplMyApi->getParcelShops($code = null, $countryCode = Country::CZ);
print_r($result);
```

### Get sprint routes

Returns array of sprint routes

```php
$pplMyApi = new Salamek\PplMyApi\Api();
$result = $pplMyApi->getSprintRoutes();
print_r($result);
```

### Create Packages

Creates package/s on PPL MyApi (sends Package object to PPL)

```php

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);

$recipient = new Salamek\PplMyApi\Model\Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'http://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = 40950000114;
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/
$weight = 3.15;
$package = new Salamek\PplMyApi\Model\Package($packageNumber, Product::PPL_PARCEL_CZ_PRIVATE, $weight, 'Testovaci balik', Depo::CODE_09, $recipient);

try
{
    $pplMyApi->createPackages([$package]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}
```

#### Empty Sender

It may happen that PPL support staff requires you to ommit the *ISender* while you send the **package** (not pallet) data. In that
case you just use null:

While sending **pallet** data, *Sender* is **required**.

### Create Orders

Creates order/s on PPL MyApi (send Order object to PPL)

```php

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);


$order = new Salamek\PplMyApi\Model\Order($countPack, $orderReferenceId, $packProductType, \DateTimeInterface $sendDate, Sender $sender, Recipient $recipient, $customerReference = null, $email = null, $note = null, \DateTimeInterface $sendTimeFrom = null, \DateTimeInterface $sendTimeTo = null);

try
{
    $pplMyApi->createOrders([$order]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}

```

### Create Pickup Orders

Creates pickup order/s on PPL MyApi (send PickupOrder object to PPL)

```php

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);

$order = new Salamek\PplMyApi\Model\PickUpOrder($orderReferenceId, $customerReference, $countPackages, $note, $email, \DateTimeInterface $sendDate, $sendTimeFrom, $sendTimeTo, Sender $sender);

try
{
    $pplMyApi->createPickupOrders([$order]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}

```

### Get Cities Routing

Returns cities routing filtered by `$countryCode`, `$dateFrom`, `$zipCode`

```php
$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);
$result = $pplMyApi->getCitiesRouting($countryCode = Country::CZ, \DateTimeInterface $dateFrom = null, $zipCode = null);
print_r($result);
```

### Get Packages

Returns package/s info from ppl filtered by `$customRefs`, `$dateFrom`, `$dateTo`, `$packageNumbers` useful for tracking and checking status of package/s

```php
$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);
$result = $pplMyApi->getPackages($customRefs = null, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null, array $packageNumbers = []);
print_r($result);
```

### Get Labels

#### PdfLabel

Returns PDF with label/s for print on paper, two decompositions are supported, LabelDecomposition::FULL (one A4 Label per page) or LabelDecomposition::QUARTER (one label per 1/4 of A4 page)

#### ZplLabel

Returns ZPL (Zebra printer format) label/s for print on paper

```php

$sender = new Salamek\PplMyApi\Model\Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'http://www.example.cz', Country::CZ);
$recipient = new Salamek\PplMyApi\Model\Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'http://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = 40950000114;
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/
$weight = 3.15;
$package = new Salamek\PplMyApi\Model\Package($packageNumber, Product::PPL_PARCEL_CZ_PRIVATE, $weight, 'Testovaci balik', Depo::CODE_09, $sender, $recipient);

// PDF Label
$rawPdf = PdfLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.pdf', $rawPdf);

// ZPL Label
$rawZpl = ZplLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.zpl', $rawZpl);
```
