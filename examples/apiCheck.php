<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

/**
 * Check if PPL MyApi is in working shape
 */

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