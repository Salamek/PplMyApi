<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Enum\Country;

/**
 * Returns cities routing filtered by $countryCode, $dateFrom, $zipCode
 */

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);
$result = $pplMyApi->getCitiesRouting(Country::CZ, null, null);
print_r($result);
