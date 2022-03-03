<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Order;

/**
 * Creates order/s on PPL MyApi (send Order object to PPL)
 */

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);


$order = new Order(
        $countPack, 
        $orderReferenceId, 
        $packProductType, 
        $sendDate,
        $sender, 
        $recipient, 
        $customerReference, 
        $email, 
        $note, 
        $sendTimeFrom, 
        $sendTimeTo
);

try
{
    $pplMyApi->createOrders([$order]);
}
catch (\Exception $e)
{
    echo $e->getMessage() . PHP_EOL;
}
