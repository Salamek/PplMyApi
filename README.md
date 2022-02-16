# Professional Parcel Logistic MyApi client in PHP

[![Test status](https://github.com/Salamek/PplMyApi/actions/workflows/php.yml/badge.svg)](https://github.com/Salamek/PplMyApi/actions/workflows/php.yml)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/salamek) 
> Please consider sponsoring if you using this package comercially, my time is not free :) You can sponsor me by clicking on "Sponsor" button in top button row. Thank You./Prosím pouvažujte nad sponzorováním tohoto projektu pokud používáte tento projekt komerčně, můj čas není zadarmo :) Sponzorovat můžete kliknutím na tlačítko "Sponsor" v horní řadě tlačítkek. Děkuji.

Professional Parcel Logistic MyApi client in PHP


## Requirements

- PHP 5.6 or higher

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
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

$pplMyApi = new Api();
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
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;


$pplMyApi = new Api();
echo $pplMyApi->getVersion() . PHP_EOL;
```

### Get parcel shops

Returns array of parcel shops filtered by `$code` and `$countryCode`

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Enum\Country;


$pplMyApi = new Api();
$result = $pplMyApi->getParcelShops($code = null, $countryCode = Country::CZ);
print_r($result);
```

### Get sprint routes

Returns array of sprint routes

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

$pplMyApi = new Api();
$result = $pplMyApi->getSprintRoutes();
print_r($result);
```

### Create Packages

Creates package/s on PPL MyApi (sends Package object to PPL)

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Enum\Product;


$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);

$recipient = new Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'https://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = '40950000114';
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/
$package = new Package($packageNumber, Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik', $recipient);

try
{
    $pplMyApi->createPackages([$package]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}
```

### Create Packages using RoutedPackage

Creates routed package/s on PPL MyApi (sends RoutedPackage object to PPL)

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Model\CityRouting;
use Salamek\PplMyApi\Enum\Product;


$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);

$recipient = new Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'https://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = '40950000114';
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/

$cityRoutingResponse = $this->pplMyApi->getCitiesRouting($country, null, $zipCode, $street);

//Get first routing from the response and test (response can contain more records, not 100% sure how this works...)
if (is_array($cityRoutingResponse)) {
  $cityRoutingResponse = $cityRoutingResponse[0];
}
if (!isset($cityRoutingResponse->RouteCode) || !isset($cityRoutingResponse->DepoCode) || !isset($cityRoutingResponse->Highlighted)) {
  throw new Exception('Štítek PPL se nepodařilo vytisknout, chybí Routing, pravděpodobně neplatná adresa!');
}

$cityRouting = new CityRouting(
    $cityRoutingResponse->RouteCode, 
    $cityRoutingResponse->DepoCode, 
    $cityRoutingResponse->Highlighted
);

//Generate SmartLabel with the help of RoutedPackage

$package = new Package($packageNumber, Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik', $recipient, $cityRouting);

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

It may happen that PPL support staff requires you to omit the *ISender* while you send the **package** (not pallet) data. In that
case you just use null:

While sending **pallet** data, *Sender* is **required**.

### Create Orders

Creates order/s on PPL MyApi (send Order object to PPL)

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Order;

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);


$order = new Order($countPack, $orderReferenceId, $packProductType, \DateTimeInterface $sendDate, Sender $sender, Recipient $recipient, $customerReference = null, $email = null, $note = null, \DateTimeInterface $sendTimeFrom = null, \DateTimeInterface $sendTimeTo = null);

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
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\PickUpOrder;

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);

$order = new PickUpOrder($orderReferenceId, $customerReference, $countPackages, $note, $email, \DateTimeInterface $sendDate, $sendTimeFrom, $sendTimeTo, Sender $sender);

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
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\PickUpOrder;
use Salamek\PplMyApi\Enum\Country;

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);
$result = $pplMyApi->getCitiesRouting($countryCode = Country::CZ, \DateTimeInterface $dateFrom = null, $zipCode = null);
print_r($result);
```

### Get Packages

Returns package/s info from ppl filtered by `$customRefs`, `$dateFrom`, `$dateTo`, `$packageNumbers` useful for tracking and checking status of package/s

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);
$result = $pplMyApi->getPackages($customRefs = null, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null, array $packageNumbers = []);
print_r($result);
```

### Get Labels

#### PdfLabel

Returns PDF with label/s for print on paper, two decompositions are supported, LabelDecomposition::FULL (one A4 Label per page) or LabelDecomposition::QUARTER (one label per 1/4 of A4 page)

#### ZplLabel

Returns ZPL (Zebra printer format) label/s for print on paper

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Tools;
use Salamek\PplMyApi\Model\PackageNumberInfo;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Model\Sender;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\PdfLabel;
use Salamek\PplMyApi\ZplLabel;


$sender = new Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'https://www.example.cz', Country::CZ);
$recipient = new Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'https://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = 40950000114;
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/
$cityRoutingResponse = $this->pplMyApi->getCitiesRouting($country, null, $zipCode, $street);

//Get first routing from the response and test (response can contain more records, not 100% sure how this works...)
if (is_array($cityRoutingResponse)) {
  $cityRoutingResponse = $cityRoutingResponse[0];
}
if (!isset($cityRoutingResponse->RouteCode) || !isset($cityRoutingResponse->DepoCode) || !isset($cityRoutingResponse->Highlighted)) {
  throw new Exception('Štítek PPL se nepodařilo vytisknout, chybí Routing, pravděpodobně neplatná adresa!');
}

$cityRouting = new CityRouting(
    $cityRoutingResponse->RouteCode, 
    $cityRoutingResponse->DepoCode, 
    $cityRoutingResponse->Highlighted
);

$package = new Package($packageNumber, Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik', $recipient, $cityRouting, $sender);

// PDF Label
$rawPdf = PdfLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.pdf', $rawPdf);

// ZPL Label
$rawZpl = ZplLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.zpl', $rawZpl);
```

# PPL Package number format
```AsciiDoc
40990019352
│├┘│└─────┴──── [0019352] SeriesNumber
││ └─────────── [9] IsCashOnDelivery 9==CoD 5== NonCoD
│└───────────── [09] DepoCode
└────────────── [4] ProductType
```

