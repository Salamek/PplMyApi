<?php

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Api;

/**
 * Returns package/s info from ppl filtered by $customRefs, $dateFrom, $dateTo, $packageNumbers useful for tracking and checking status of package/s
 */

$username = 'my_api_username';
$password = 'my_api_password';
$customerId = 'my_api_customer_id';

$pplMyApi = new Api($username, $password, $customerId);



$customRefs = null;
$dateFrom = new \DateTime();
$dateFrom->modify('-2 days'); //From 2 days ago
$dateTo = new \DateTime(); // To NOW

$packageNumbers = []; // Specify array of package numbers to check

$result = $pplMyApi->getPackages(
        $customRefs = null, 
        $dateFrom, 
        $dateTo,
        $packageNumbers
);
print_r($result);
