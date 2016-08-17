<?php

use Salamek\PplMyApi\Api;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\Sender;
use Salamek\PplMyApi\Model\Recipient;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Country;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    /** @var Api */
    public $pplMyApi;

    /** @var Package */
    public $package;

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

        $this->package = new Package(115, Product::PPL_PARCEL_CZ_PRIVATE, '10', 'Testpvaci balik', Depo::CODE_09, $sender, $recipient);
    }

}