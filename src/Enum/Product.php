<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class Product
{
    const PPL_PARCEL_CZ_BUSINESS = 1;
    const PPL_PARCEL_CZ_BUSINESS_COD = 2;
    const PPL_PARCEL_CZ_AFTERNOON_PACKAGE = 7;
    const PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD = 8;
    const EXPORT_PACKAGE = 9;
    const EXPORT_PACKAGE_COD = 10;
    const PPL_PARCEL_IMPORT = 11;
    const PPL_PARCEL_CZ_PRIVATE = 13;
    const PPL_PARCEL_CZ_PRIVATE_COD = 14;
    const COMPANY_PALETTE = 15; // !FIXME this one is missing in the DOC PDF
    const COMPANY_PALETTE_COD = 16; // !FIXME this one is missing in the DOC PDF
    const PRIVATE_PALETTE = 19; // !FIXME this one is missing in the DOC PDF
    const PRIVATE_PALETTE_COD = 20; // !FIXME this one is missing in the DOC PDF
    const PPL_PARCEL_CONNECT = 36;
    const PPL_PARCEL_CONNECT_COD = 37;
    const PPL_PARCEL_CZ_RETURN = 45;
    const PPL_PARCEL_CZ_SMART = 46;
    const PPL_PARCEL_CZ_SMART_COD = 47;
    const PPL_PARCEL_SMART_EUROPE = 48;
    const PPL_PARCEL_SMART_EUROPE_COD = 49;

    /** @var array */
    public static $list = [
        self::PPL_PARCEL_CZ_BUSINESS,
        self::PPL_PARCEL_CZ_BUSINESS_COD,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD,
        self::EXPORT_PACKAGE,
        self::EXPORT_PACKAGE_COD,
        self::PPL_PARCEL_CZ_PRIVATE,
        self::PPL_PARCEL_CZ_PRIVATE_COD,
        self::COMPANY_PALETTE,
        self::COMPANY_PALETTE_COD,
        self::PRIVATE_PALETTE,
        self::PRIVATE_PALETTE_COD,
        self::PPL_PARCEL_CONNECT,
        self::PPL_PARCEL_CONNECT_COD,
        self::PPL_PARCEL_CZ_RETURN,
        self::PPL_PARCEL_CZ_SMART,
        self::PPL_PARCEL_CZ_SMART_COD,
        self::PPL_PARCEL_SMART_EUROPE,
        self::PPL_PARCEL_SMART_EUROPE_COD
    ];

    public static $names = [
        self::PPL_PARCEL_CZ_BUSINESS => 'PPL Parcel CZ Business',
        self::PPL_PARCEL_CZ_BUSINESS_COD => 'PPL Parcel CZ Business - dobírka',
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE => 'PPL Parcel CZ Dopolední balík',
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD => 'PPL Parcel CZ Dopolední balík - dobírka',
        self::EXPORT_PACKAGE => 'Exportní balík',
        self::EXPORT_PACKAGE_COD => 'Exportní balík - dobírka',
        self::PPL_PARCEL_CZ_PRIVATE => 'PPL Parcel CZ Private',
        self::PPL_PARCEL_CZ_PRIVATE_COD => 'PPL Parcel CZ Private - dobírka',
        self::PPL_PARCEL_CONNECT => 'PPL Parcel Connect',
        self::PPL_PARCEL_CONNECT_COD=> 'PPL Parcel Connect – dobírka',
        self::PPL_PARCEL_CZ_RETURN=> 'PPL Parcel Return CZ',
        self::PPL_PARCEL_CZ_SMART=> 'PPL Parcel CZ Smart',
        self::PPL_PARCEL_CZ_SMART_COD=> 'PPL Parcel CZ Smart – dobírka',
        self::PPL_PARCEL_SMART_EUROPE=> 'PPL Parcel Smart Europe',
        self::PPL_PARCEL_SMART_EUROPE_COD=> 'PPL Parcel Smart Europe – dobírka'
    ];

    public static $cashOnDelivery = [
        self::PPL_PARCEL_CZ_BUSINESS_COD,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD,
        self::EXPORT_PACKAGE_COD,
        self::PPL_PARCEL_CZ_PRIVATE_COD,
        self::COMPANY_PALETTE_COD,
        self::PRIVATE_PALETTE_COD,
        self::PPL_PARCEL_CONNECT_COD,
        self::PPL_PARCEL_CZ_SMART_COD,
        self::PPL_PARCEL_SMART_EUROPE_COD
    ];

    public static $deliverySaturday = [
        self::PPL_PARCEL_CZ_BUSINESS,
        self::PPL_PARCEL_CZ_BUSINESS_COD,
        self::PPL_PARCEL_CZ_PRIVATE,
        self::PPL_PARCEL_CZ_PRIVATE_COD,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD,
        self::EXPORT_PACKAGE,
        self::EXPORT_PACKAGE_COD,
        self::PPL_PARCEL_CZ_SMART,
        self::PPL_PARCEL_CZ_SMART_COD,
        self::PPL_PARCEL_SMART_EUROPE,
        self::PPL_PARCEL_SMART_EUROPE_COD
    ];

    public static $privateProducts = [
        self::PPL_PARCEL_CZ_PRIVATE,
        self::PPL_PARCEL_CZ_PRIVATE_COD,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD
    ];

    public static function getName($product) {
        return self::$names[$product];
    }
}
