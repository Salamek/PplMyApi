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
    const COMPANY_PALETTE = 15;
    const COMPANY_PALETTE_COD = 16;
    const PRIVATE_PALETTE = 19;
    const PRIVATE_PALETTE_COD = 20;

    /** @var array  */
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
        self::PRIVATE_PALETTE_COD
    ];

    public static $cashOnDelivery = [
        self::PPL_PARCEL_CZ_BUSINESS_COD,
        self::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD,
        self::EXPORT_PACKAGE_COD,
        self::PPL_PARCEL_CZ_PRIVATE_COD,
        self::COMPANY_PALETTE_COD,
        self::PRIVATE_PALETTE_COD
    ];
}