<?php declare(strict_types = 1);

require __DIR__.'/vendor/autoload.php';

use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Model\Sender;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\PdfLabel;
use Salamek\PplMyApi\ZplLabel;


$sender = new Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'https://www.example.cz', Country::CZ);
$recipient = new Recipient('Olomouc', 'Adam Schubert', 'My Address', '77900', 'adam@example.com', '+420123456789', 'https://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

$packageNumber = 40950000114;

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
// Returns PDF with label/s for print on paper, two decompositions are supported, LabelDecomposition::FULL 
// (one A4 Label per page) or LabelDecomposition::QUARTER (one label per 1/4 of A4 page)
$rawPdf = PdfLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.pdf', $rawPdf);

// ZPL Label
// Returns ZPL (Zebra printer format) label/s for print on paper
$rawZpl = ZplLabel::generateLabels([$package]);
file_put_contents($package->getPackageNumber() . '.zpl', $rawZpl);