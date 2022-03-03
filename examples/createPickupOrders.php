<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\PickUpOrder;

/**
 * Creates pickup order/s on PPL MyApi (send PickupOrder object to PPL)
 */

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);

$order = new PickUpOrder(
        $orderReferenceId, 
        $customerReference, 
        $countPackages, 
        $note, 
        $email, 
        $sendDate, 
        $sendTimeFrom, 
        $sendTimeTo,
        $sender
        );

try
{
    $pplMyApi->createPickupOrders([$order]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}
