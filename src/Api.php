<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi;

use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Model\Order;
use Salamek\PplMyApi\Model\Package;
use Salamek\PplMyApi\Model\PickUpOrder;

/**
 * Class Client
 * @package Salamek
 * ######## BUGS ###########
 * 1) SSL IS NOT VALID
 * 2) API SHOULD GENERATE ID
 * 3) API SHOULD GENERATE LABELS
 *
 * ######### BUGS IN DOC #######
 * isHealtly:
 * * Navratova hodnota je Human readable string, nebyl by lepsi boolean ? Tohle api nepouzivaji lide ale stroje
 * Login tabulka parametru obsahuje :
 * * AuthToken Coz by nemela protoze AuthToken ziskavam z funkce Login
 * * CustId chybi informace zda li je Required ci ne
 * * Username chybi informace zda li je Required ci ne
 * * Password chybi informace zda li je Required ci ne
 * * Username delka je napsana jako 32 znaku, spravne by melo byt "maximalni delka"
 * * Password delka je napsana jako 32 znaku, spravne by melo byt "maximalni delka"
 * Login example XML obsahuje:
 * * UserName ale v tabulce parameteru je Username, co je spravne ? Username nefunguje UserName funguje
 * GetParcelShops tabulka parametru obsahuje:
 * * Code delka je napsana jako 50 znaku, spravne by melo byt "maximalni delka"
 * * AuthToken chybi v tabulce parametru, pravdepodobne je ale potreba ?
 * GetParcelShops vraci objekt: a ne chybu kdyz neni AuthToken
 * * [GetParcelShopsResult] => stdClass Object
 * * (
 * * [AuthToken] =>
 * * [ResultData] =>
 * * )
 * GetPackages:
 * * PackNumbers: Vypada jako array a ne string, dle nazvu a obsahu XML
 *
 * Obj.Sender.Contact = 30 chracters VS Obj.Recipient.Contact = 300 WOOT ?
 * Obj.Sender.Email = 100 chracters VS Obj.Recipient.Email = 50 WOOT ?
 * Obj.Sender.Name = 250 chracters VS Obj.Recipient.Name = 50 WOOT ?
 * Obj.Sender.Name2 = 250 chracters VS Obj.Recipient.Name2 = 50 WOOT ?
 * Obj.Sender.Name2 = 250 chracters VS Obj.Recipient.Name2 = 50 WOOT ?
 * Obj.Sender.Street = 30 chracters VS Obj.Recipient.Street = 50 WOOT ?
 *
 * V CreateOrder je SendTimeFrom/SendTimeTo ve formatu YYYY-MM-DDThh:MM:SS a v CreatePackages je SpecDelivTimeFrom/SpecDelivTimeTo/SpecTakeTimeFrom/SpecTakeTimeTo ve formatu hh:mm:ss
 * V CreateOrder je SendDate ve formatu YYYY-MM-DDThh:MM:SS v CreatePackages je SpecDelivDate/SpecTakeDate ve formatu YYYY-MM-DD
 *
 * V CreatePackages tabulce parametru je rozbite odsazeni, nelze poznat do jake skupiny spada ktery parametr
 * PRODUCT_TYPE_PRIVATE_PALETTE_COD neodpovida identifikatoru na stitku, na nem je jiny identifikator a zvlast COD bool... takze stejny LEN jen jine cisla... blbost
 * Neni zadne testovaci api na kterem by se dala otestovat spravna implementace, musi se testovat na ostrych datech!!!
 * Identifikator CoD v kodu zasilky je bud 9 pro CoD a 5 pro NonCoD proc to neni 1 pro CoD a 0 pro NonCoD ??? V doc uplne chybi ze 5 je NonCoD, musel jsem to vykoukat ze systemem generovanych identifiaktoru
 * Bylo by dobre kdyby mel kazdy Package neco jako volitelny OrderId... omrknout jestli tam neco takoveho neni schovaneho ???
 * V CreatePackages je duplicitni info Weight a WeightedPackageInfoIn->Weight !!!
 *
 * Ciselna rada, rozsahy, jejich vycerpani, nutnost implementovat do API
 *
 * createPackages nekontroluje duplicitu PackNumber, co se stane kdyz poslu vicekrat se stejnym PackNumber ? prepisou se data ? Nemelo by toto byt nejak uvedeno v DOC ?
 */
class Api
{
    /** @var null|\SoapClient */
    private $soap = null;

    /** @var string */
    private $wsdl = 'https://myapi.ppl.cz/MyApi.svc?singleWsdl';

    /** @var null|string */
    private $username;

    /** @var null|string */
    private $password;

    /** @var null|integer */
    private $customerId = null;

    /** @var null|string */
    private $securedStorage = null;

    /** @var string */
    private $tokenLifespan = '+30 minutes'; //DateTime::modify() format

    /**
     * MyApi constructor.
     * @param null|string $username
     * @param null|string $password
     * @param null|integer $customerId
     * @throws \Exception
     */
    public function __construct($username = null, $password = null, $customerId = null)
    {
        if (strlen($username) > 32)
        {
            throw new \Exception('$username is longer then 32 characters');
        }

        if (strlen($password) > 32)
        {
            throw new \Exception('$password is longer then 32 characters');
        }

        $this->username = $username;
        $this->password = $password;
        $this->customerId = $customerId;

        $this->securedStorage = sys_get_temp_dir().'/'.__CLASS__;


        try {
            //!FIXME ####################### SECURITY ##########################
            //!FIXME Special options to pass invalid SSL certificate on *.ppl.cz
            //!FIXME ####################### SECURITY ##########################
            $options = [
                "location" => "https://myapi.ppl.cz/MyApi.svc",
                "trace" => 1,
                "stream_context" => stream_context_create([
                        "ssl" => [
                            "verify_peer" => false,
                            "allow_self_signed" => false
                        ]
                    ]
                )
            ];
            $this->soap = new \SoapClient($this->wsdl, $options);

        } catch (\Exception $e) {
            throw new \Exception('Failed to build soap client');
        }

        if (!$this->isHealtly())
        {
            throw new \Exception('PPL MyAPI is offline');
        }
    }

    /**
     * @return mixed
     */
    private function getAuthToken()
    {
        if (file_exists($this->securedStorage))
        {
            $modified = new \DateTime('@'.filemtime($this->securedStorage));
            $modified->modify($this->tokenLifespan);

            if ($modified > new \DateTime())
            {
                return trim(file_get_contents($this->securedStorage));
            }
        }

        $token = $this->login();
        file_put_contents($this->securedStorage, $token);

        return $token;
    }

    /**
     * @return bool
     */
    public function isHealthy()
    {
        try {
            $response = $this->soap->isHealtly();
            return $response->IsHealtlyResult == 'Healthy';
        } catch(\Exception $e){
            return false;
        }
    }

    public function getVersion()
    {
        return $this->soap->Version()->VersionResult;
    }

    /**
     * @param null $code
     * @param string $countryCode
     * @return mixed
     * @throws \Exception
     */
    public function getParcelShops($code = null, $countryCode = Country::CZ)
    {
        if (!in_array($countryCode, Country::$list))
        {
            throw new \Exception(sprintf('Country Code %s is not supported, use one of %s', $countryCode, implode(', ', Country::$list)));
        }

        $result = $this->soap->GetParcelShops([
            'Filter' => [
                'Code' => $code,
                'CountryCode' => $countryCode
            ]
        ]);

        return $result->GetParcelShopsResult->ResultData->MyApiParcelShop;
    }

    /**
     * @param string $countryCode
     * @param \DateTimeInterface|null $dateFrom
     * @param null $zipCode
     * @return mixed
     * @throws \Exception
     */
    public function getCitiesRouting($countryCode = Country::CZ, \DateTimeInterface $dateFrom = null, $zipCode = null)
    {
        if (!in_array($countryCode, Country::$list))
        {
            throw new \Exception(sprintf('Country Code %s is not supported, use one of %s', $countryCode, implode(', ', Country::$list)));
        }

        $result = $this->soap->GetCitiesRouting([
            'Auth' => [
                'AuthToken' => $this->getAuthToken(),
            ],
            'Filter' => [
                'CountryCode' => $countryCode,
                'DateFrom' => ($dateFrom ? $dateFrom->format('Y-m-d') : null),
                'ZipCode' => $zipCode
            ]
        ]);

        return $result->GetCitiesRoutingResult->ResultData->MyApiCityRouting;
    }

    /**
     * @param null $customRefs
     * @param \DateTimeInterface|null $dateFrom
     * @param \DateTimeInterface|null $dateTo
     * @param array $packageNumbers
     * @throws \Exception
     * @return mixed
     */
    public function getPackages($customRefs = null, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null, array $packageNumbers = [])
    {
        if (is_null($customRefs) && is_null($dateFrom) && is_null($dateTo) && empty($packageNumbers))
        {
            throw new \Exception('At least one parameter must be specified!');
        }

        $result = $this->soap->GetPackages([
            'Auth' => [
                'AuthToken' => $this->getAuthToken(),
            ],
            'Filter' => [
                'CustRefs' => $customRefs,
                'DateFrom' => ($dateFrom ? $dateFrom->format('Y-m-d') : null),
                'DateTo' => ($dateTo ? $dateTo->format('Y-m-d') : null),
                'PackNumbers' => $packageNumbers
            ]
        ]);

        return $result->GetPackagesResult->ResultData->MyApiPackageOut;
    }

    /**
     * @param array $orders
     * @return mixed
     * @throws \Exception
     */
    public function createOrders(array $orders)
    {
        $ordersProcessed = [];

        /** @var Order $order */
        foreach ($orders AS $order)
        {
            if (!$order instanceof Order)
            {
                throw new \Exception('$orders must contain only instances of Order class');
            }

            $ordersProcessed[] = [
                'CountPack' => $order->getCountPackages(),
                'CustRef' => $order->getCustomerReference(),
                'Email' => $order->getEmail(),
                'Note' => $order->getNote(),
                'OrdRefID' => $order->getOrderReferenceId(),
                'PackProductType' => $order->getPackageProductType(),
                'SendDate' => $order->getSendDate()->format(\DateTime::ATOM),
                'SendTimeFrom' => $order->getSendTimeFrom()->format(\DateTime::ATOM),
                'SendTimeTo' => $order->getSendTimeTo()->format(\DateTime::ATOM),
                'Sender' => [
                    'City' => $order->getSender()->getCity(),
                    'Contact' => $order->getSender()->getContact(),
                    'Country' => $order->getSender()->getCountry(),
                    'Email' => $order->getSender()->getEmail(),
                    'Name' => $order->getSender()->getName(),
                    'Name2' => $order->getSender()->getName2(),
                    'Phone' => $order->getSender()->getPhone(),
                    'Street' => $order->getSender()->getStreet(),
                    'ZipCode' => $order->getSender()->getZipCode()
                ],
                'Recipient' => [
                    'City' => $order->getRecipient()->getCity(),
                    'Contact' => $order->getRecipient()->getContact(),
                    'Country' => $order->getRecipient()->getCountry(),
                    'Email' => $order->getRecipient()->getEmail(),
                    'Name' => $order->getRecipient()->getName(),
                    'Name2' => $order->getRecipient()->getName2(),
                    'Phone' => $order->getRecipient()->getPhone(),
                    'Street' => $order->getRecipient()->getStreet(),
                    'ZipCode' => $order->getRecipient()->getZipCode()
                ]
            ];
        }

        $result = $this->soap->CreateOrders([
            'Auth' => [
                'AuthToken' => $this->getAuthToken(),
            ],
            'Orders' => [
                'MyApiOrderIn' => $ordersProcessed
            ]
        ]);

        return $result;
    }

    public function createPackages(array $packages, $customerUniqueImportId = null)
    {
        $packagesProcessed = [];
        /** @var Order $order */
        foreach ($packages AS $package) {
            if (!$package instanceof Package) {
                throw new \Exception('$packages must contain only instances of Package class');
            }

            $packagesProcessed[] = [
                'PackNumber' => $package->getPackageNumber(),
                'PackProductType' => $package->getPackageProductType(),
                'Weight' => $package->getWeight(),
                'Note' => $package->getNote(),
                'DepoCode' => $package->getDepoCode(),
                'Sender' => [
                    'City' => $package->getSender()->getCity(),
                    'Contact' => $package->getSender()->getContact(),
                    'Country' => $package->getSender()->getCountry(),
                    'Email' => $package->getSender()->getEmail(),
                    'Name' => $package->getSender()->getName(),
                    'Name2' => $package->getSender()->getName2(),
                    'Phone' => $package->getSender()->getPhone(),
                    'Street' => $package->getSender()->getStreet(),
                    'ZipCode' => $package->getSender()->getZipCode()
                ],
                'Recipient' => [
                    'City' => $package->getRecipient()->getCity(),
                    'Contact' => $package->getRecipient()->getContact(),
                    'Country' => $package->getRecipient()->getCountry(),
                    'Email' => $package->getRecipient()->getEmail(),
                    'Name' => $package->getRecipient()->getName(),
                    'Name2' => $package->getRecipient()->getName2(),
                    'Phone' => $package->getRecipient()->getPhone(),
                    'Street' => $package->getRecipient()->getStreet(),
                    'ZipCode' => $package->getRecipient()->getZipCode()
                ],
                'SpecDelivery' => ($package->getSpecialDelivery() ? [
                    'ParcelShopCode' => $package->getSpecialDelivery()->getParcelShopCode(),
                    'SpecDelivDate' => $package->getSpecialDelivery()->getDeliveryDate()->format('Y-m-d'),
                    'SpecDelivTimeFrom' => $package->getSpecialDelivery()->getDeliveryTimeFrom()->format('H:i:s'),
                    'SpecDelivTimeTo' => $package->getSpecialDelivery()->getDeliveryTimeTo()->format('H:i:s'),
                    'SpecTakeDate' => $package->getSpecialDelivery()->getTakeDate()->format('Y-m-d'),
                    'SpecTakeTimeFrom' => $package->getSpecialDelivery()->getTakeTimeFrom()->format('H:i:s'),
                    'SpecTakeTimeTo' => $package->getSpecialDelivery()->getTakeTimeTo()->format('H:i:s')
                ] : null),
                'PaymentInfo' => ($package->getPaymentInfo() ? [
                    'BankAccount' => $package->getPaymentInfo()->getBankAccount(),
                    'BankCode' => $package->getPaymentInfo()->getBankCode(),
                    'CodCurrency' => $package->getPaymentInfo()->getCashOnDeliveryCurrency(),
                    'CodPrice' => $package->getPaymentInfo()->getCashOnDeliveryPrice(),
                    'CodVarSym' => $package->getPaymentInfo()->getCashOnDeliveryVariableSymbol(),
                    'IBAN' => $package->getPaymentInfo()->getIban(),
                    'InsurCurrency' => $package->getPaymentInfo()->getInsuranceCurrency(),
                    'InsurPrice' => $package->getPaymentInfo()->getInsurancePrice(),
                    'SpecSymbol' => $package->getPaymentInfo()->getSpecificSymbol(),
                    'Swift' => $package->getPaymentInfo()->getSwift(),
                ] : null),
                'PackagesExtNums' => ($package->getExternalNumbers() ? [
                    'MyApiPackageExtNum' => [
                        'Code' => $package->getExternalNumbers()->getCode(),
                        'ExtNumber' => $package->getExternalNumbers()->getExternalNumber(),
                    ]
                ] : null)
            ];
        }


        $result = $this->soap->CreatePackages([
            'Auth' => [
                'AuthToken' => $this->getAuthToken(),
            ],
            'CustomerUniqueImportId' => $customerUniqueImportId,
            'Packages' => [
                'MyApiPackageIn' => $packagesProcessed
            ]
        ]);

        return $result;
    }

    /**
     * @param array $pickupOrders
     * @return mixed
     * @throws \Exception
     */
    public function createPickupOrders(array $pickupOrders)
    {
        $pickupOrdersProcessed = [];
        /** @var Order $order */
        foreach ($pickupOrders AS $pickupOrder) {
            if (!$pickupOrder instanceof PickUpOrder) {
                throw new \Exception('$pickupOrders must contain only instances of PickUpOrder class');
            }

            $pickupOrdersProcessed[] = [
                'OrdRefId' => $pickupOrder->getOrderReferenceId(),
                'CustRef' => $pickupOrder->getCustomerReference(),
                'CountPack' => $pickupOrder->getCountPackages(),
                'Note' => $pickupOrder->getNote(),
                'Email' => $pickupOrder->getEmail(),
                'SendDate' => $pickupOrder->getSendDate()->format('Y-m-d'),
                'SendTimeFrom' => $pickupOrder->getSendTimeFrom()->format(\DateTime::ATOM),
                'SendTimeTo' => $pickupOrder->getSendTimeTo()->format(\DateTime::ATOM),
                'Sender' => [
                    'City' => $pickupOrder->getSender()->getCity(),
                    'Contact' => $pickupOrder->getSender()->getContact(),
                    'Country' => $pickupOrder->getSender()->getCountry(),
                    'Email' => $pickupOrder->getSender()->getEmail(),
                    'Name' => $pickupOrder->getSender()->getName(),
                    'Name2' => $pickupOrder->getSender()->getName2(),
                    'Phone' => $pickupOrder->getSender()->getPhone(),
                    'Street' => $pickupOrder->getSender()->getStreet(),
                    'ZipCode' => $pickupOrder->getSender()->getZipCode()
                ],
            ];
        }

        $result = $this->soap->CreatePickupOrders([
            'Auth' => [
                'AuthToken' => $this->getAuthToken(),
            ],
            'Orders' => [
                'MyApiPickUpOrderIn' => $pickupOrdersProcessed
            ]
        ]);

        return $result;
    }

    /**
     * @return mixed
     */
    public function getSprintRoutes()
    {
        $result = $this->soap->GetSprintRoutes();
        return $result->GetSprintRoutesResult->ResultData->MyApiSprintRoutes;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        $result = $this->soap->Login([
            'Auth' => [
                'CustId' => $this->customerId,
                'UserName' => $this->username,
                'Password' => $this->password
            ]
        ]);


        return $result->LoginResult->AuthToken;
    }
}
