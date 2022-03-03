<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

/**
 * Returns array of sprint routes
 */

$pplMyApi = new Api();
$result = $pplMyApi->getSprintRoutes();
print_r($result);
