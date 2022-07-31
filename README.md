# Professional Parcel Logistic MyApi client in PHP with PDF and ZPL label generator

[![Test status](https://github.com/Salamek/PplMyApi/actions/workflows/php.yml/badge.svg)](https://github.com/Salamek/PplMyApi/actions/workflows/php.yml)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/salamek) 
> Please consider sponsoring if you're using this package commercially, my time is not free :) You can sponsor me by clicking on "Sponsor" button in top button row. Thank You./Prosím pouvažujte nad sponzorováním tohoto projektu pokud používáte tento projekt komerčně, můj čas není zadarmo :) Sponzorovat můžete kliknutím na tlačítko "Sponsor" v horní řadě tlačítkek. Děkuji.

Professional Parcel Logistic MyApi client in PHP with PDF and ZPL label generator


## Requirements

- PHP 7.3 or higher

## Installation

Install salamek/PplMyApi using  [Composer](http://getcomposer.org/)

```sh
$ composer require salamek/ppl-my-api
```

or if you want master branch code:

```sh
$ composer require salamek/ppl-my-api:dev-master
```

## Credentials

You must request MyAPI credentials from PPL IT, it is not same as klient.ppl.cz credentials!

## Usage

Consult official PPL documentation for methods description

~Runnable examples of code are in [examples](examples) folder of this project.

* [apiCheck.php](examples/apiCheck.php) Simple example to test connection to PPL MyApi
* [getApiVersion.php](examples/getApiVersion.php) Simple example to show how to get MyApi version
* [createPackages.php](examples/createPackages.php) Example how to create basic packages
* [createPackagesWithCod.php](examples/createPackagesWithCod.php) Example how to create packages with COD (Cash On Delivery)
* [createPackagesWithService.php](examples/createPackagesWithService.php) Example how to create packages with additional services
* [createPickupOrders.php](examples/createPickupOrders.php) Example how to create Pickup Orders
* [createOrders.php](examples/createOrders.php) Example how to create Orders
* [getCitiesRouting.php](examples/getCitiesRouting.php) Example how to get cities routing
* [getLabel.php](examples/getLabel.php) Example to show how to generate PDF and ZPL labels for print
* [getPackages.php](examples/getPackages.php) Example to show how to get list of created packages
* [getParcelShops.php](examples/getParcelShops.php) Example to show how to get list of parcel shops
* [getSprintRoutes.php](examples/getSprintRoutes.php) Example to show how to get list of sprint routes



## PPL Package number format
```AsciiDoc
40990019352
│├┘│└─────┴──── [0019352] SeriesNumber
││ └─────────── [9] IsCashOnDelivery 9==CoD & 5== NonCoD (for some product it is 8==CoD & 0=NonCoD)
│└───────────── [09] DepoCode
└────────────── [4] ProductType
```

