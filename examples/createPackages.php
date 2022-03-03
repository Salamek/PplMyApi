<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Model\CityRouting;
use Salamek\PplMyApi\Enum\Product;

/**
 * Creates package/s on PPL MyApi (sends Package object to PPL)
 */

/**
 * 
It may happen that PPL support staff requires you to omit the ISender while you send the package (not pallet) data. In that case you just use null:

While sending pallet data, Sender is required.
 */

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);

$country = Country::CZ;
$city = 'Olomouc';
$street = 'My Address';
$zipCode = '77900';

$recipient = new Recipient($city, 'Adam Schubert', $street, $zipCode, 'adam@example.com', '+420123456789', 'https://www.salamek.cz', $country, 'My Compamy a.s.');

$packageNumber = '40950000114';
/* Or you can use Tools::generatePackageNumber to get this number only from $packageSeriesNumberId like 114
$packageSeriesNumberId = 114;
$packageNumberInfo = new PackageNumberInfo($packageSeriesNumberId, Product::PPL_PARCEL_CZ_PRIVATE, Depo::CODE_09);
$packageNumber = Tools::generatePackageNumber($packageNumberInfo); //40950000114
*/

$cityRoutingResponse = $pplMyApi->getCitiesRouting($country, null, $zipCode, $street);

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
