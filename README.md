# Professional Parcel Logistic MyApi client in PHP

[![Build Status](https://travis-ci.org/Salamek/PplMyApi.svg?branch=master)](https://travis-ci.org/Salamek/PplMyApi)

Professional Parcel Logistic MyApi client in PHP


## Requirements

- PHP 5.4 or higher

## Installation

Install salamek/PplMyApi using  [Composer](http://getcomposer.org/)
```sh
$ composer require salamek/PplMyApi:dev-master
```


## Usage

### Is API healthy

```php
$pplMyApi = new Salamek\PplMyApi\Api();
if ($pplMyApi->isHealthy())
{
    echo 'Healthly';
}
else
{
    echo 'Dead :(';
}
```

### Get API version

```php
$pplMyApi = new Salamek\PplMyApi\Api();
echo $pplMyApi->getVersion();
```

### Get parcel shops

```php
$pplMyApi = new Salamek\PplMyApi\Api();
$result = $pplMyApi->getParcelShops($code = null, $countryCode = Country::CZ);
print_r($result);
```

### Get sprint routes

```php
$pplMyApi = new Salamek\PplMyApi\Api();
$result = $pplMyApi->getSprintRoutes();
print_r($result);
```

### Create Package

```php

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);

$sender = new Salamek\PplMyApi\Model\Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'http://www.example.cz', Country::CZ);
$recipient = new Salamek\PplMyApi\Model\Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'http://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$myPackageIdFromNumberSeries = 115;
$weight = 3.15;
$package = new Salamek\PplMyApi\Model\Package($myPackageIdFromNumberSeries, Product::PPL_PARCEL_CZ_PRIVATE, $weight, 'Testpvaci balik', Depo::CODE_09, $sender, $recipient);

try
{
    $pplMyApi->createPackages([$package]);
}
catch (\Exception $e)
{
    echo $e->getMessage();
}

```

### Create Orders

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
    echo $e->getMessage();
}

```

### Create Pickup Orders

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
    echo $e->getMessage();
}

```

### Get Cities Routing

```php
$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);
$result = $pplMyApi->getCitiesRouting($countryCode = Country::CZ, \DateTimeInterface $dateFrom = null, $zipCode = null);
print_r($result);
```

### Get Packages

```php
$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Salamek\PplMyApi\Api($username, $password, $customerId);
$result = $pplMyApi->getPackages($customRefs = null, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null, array $packageNumbers = []);
print_r($result);
```