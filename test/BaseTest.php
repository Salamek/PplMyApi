<?php

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Sender;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Model\PaymentInfo;
use Salamek\PplMyApi\Enum\Currency;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    /** @var Api */
    public $pplMyApi;

    /** @var Package */
    public $package;

    /** @var Package[] */
    public $packages;

    /** @var bool */
    public $anonymous = true;

    public function setUp()
    {
        $configPath = __DIR__.'/config.json';
        if (file_exists($configPath))
        {
            $config = json_decode(file_get_contents($configPath));
            $this->pplMyApi = new Api($config->username, $config->password, $config->customerId);
            $this->anonymous = false;
        }
        else
        {
            $this->pplMyApi = new Api();
            $this->anonymous = true;
        }
        
        $sender = new Sender('Olomouc', 'My Compamy s.r.o.', 'My Address', '77900', 'info@example.com', '+420123456789', 'http://www.example.cz', Country::CZ);
        $recipient = new Recipient('Olomouc', 'Adam Schubert', 'Na tabulovem vrchu 7', '77900', 'adam.schubert@example.com', '+420123456789', 'http://www.salamek.cz', Country::CZ, 'My Compamy a.s.');
        $paymentInfo = new PaymentInfo(4000, Currency::CZK, '123456');

        $this->package = new Package(115, Product::PPL_PARCEL_CZ_PRIVATE, 10, 'Testpvaci balik', Depo::CODE_09, $sender, $recipient);

        $this->packages[] = new Package(116, Product::PPL_PARCEL_CZ_PRIVATE, 1, 'Testpvaci balik 1', Depo::CODE_01, $sender, $recipient);

        //These two are together
        $this->packages[] = new Package(117, Product::PPL_PARCEL_CZ_PRIVATE_COD, 2, 'Testpvaci balik 2', Depo::CODE_02, $sender, $recipient, null, $paymentInfo, null, 2, 1);
        $this->packages[] = new Package(118, Product::PPL_PARCEL_CZ_PRIVATE, 3, 'Testpvaci balik 3', Depo::CODE_02, $sender, $recipient, null, null, null, 2, 2);

        $this->packages[] = new Package(119, Product::PPL_PARCEL_CZ_PRIVATE, 4, 'Testpvaci balik 4', Depo::CODE_04, $sender, $recipient);
        $this->packages[] = new Package(120, Product::PPL_PARCEL_CZ_PRIVATE, 5, 'Testpvaci balik 5', Depo::CODE_05, $sender, $recipient);
    }

}