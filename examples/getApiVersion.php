<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

/**
 * Returns version of PPL MyApi
 */

$pplMyApi = new Api();
echo $pplMyApi->getVersion() . PHP_EOL;