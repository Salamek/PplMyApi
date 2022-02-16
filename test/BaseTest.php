<?php

use PHPUnit\Framework\TestCase;
use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Enum\Currency;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\PaymentInfo;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Model\Sender;
use Salamek\PplMyApi\Model\CityRouting;
use Salamek\PplMyApi\Enum\Depo;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
abstract class BaseTest extends TestCase
{
    /** @var Api */
    public $pplMyApi;

    /** @var Package */
    public $package;

    /** @var Package[] */
    public $packages;

    /** @var bool */
    public $anonymous = true;

    public function setUp(): void
    {
        $configPath = __DIR__ . '/config.json';
        if (file_exists($configPath)) {
            $config = json_decode(file_get_contents($configPath));
            $this->pplMyApi = new Api($config->username, $config->password, $config->customerId);
            $this->anonymous = false;
        } else {
            $this->pplMyApi = new Api();
            $this->anonymous = true;
        }

        $sender = new Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'https://www.example.cz', Country::CZ);
        $recipient = new Recipient('Olomouc', 'Adam Schubert', 'Na tabulovem vrchu 7', '77900', 'adam.schubert@example.com', '+420123456789', 'https://www.salamek.cz', Country::CZ, 'My Compamy a.s.');

        $cityRouting = new CityRouting('123', Depo::CODE_02, true);

        $this->package = new Package('40950000115', Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik',  $recipient, $cityRouting, $sender);

        $this->packages[] = new Package('40950000116', Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik 1',  $recipient, $cityRouting, $sender);


        //These two are together and first one is with POD
        $paymentInfo = new PaymentInfo(4000, Currency::CZK, '123456');
        $packageFirst = new Package('40950000117', Product::PPL_PARCEL_CZ_PRIVATE_COD, 'Testovaci balik 2',  $recipient, $cityRouting, $sender, null, null, $paymentInfo);
        $packageFirst->setPackageCount(2);
        $packageFirst->setPackagePosition(1);

        $paymentInfoNull = new PaymentInfo(0, Currency::CZK, '123456');
        $packageSecond = new Package('40950000118', Product::PPL_PARCEL_CZ_PRIVATE_COD, 'Testovaci balik 3',  $recipient, $cityRouting, $sender, null, null, $paymentInfoNull);
        $packageSecond->setPackageCount(2);
        $packageSecond->setPackagePosition(2);

        $this->packages[] = $packageFirst;
        $this->packages[] = $packageSecond;


        $this->packages[] = new Package('40950000119', Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik 4',  $recipient, $cityRouting, $sender);
        $this->packages[] = new Package('40950000120', Product::PPL_PARCEL_CZ_PRIVATE, 'Testovaci balik 5', $recipient, $cityRouting, $sender);
    }

}