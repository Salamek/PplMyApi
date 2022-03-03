<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Enum\Country;

/**
 * Returns array of parcel shops filtered by $code and $countryCode
 */

$pplMyApi = new Api();
$result = $pplMyApi->getParcelShops($code = null, $countryCode = Country::CZ);
print_r($result);
