<?php
/**
 * Copyright (C) 2023 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class AccessPointType
{
    const NONE = 'None';
    const PARCEL_SHOP = 'ParcelShop';
    const ZABKA_POINT = 'ZabkaPoint';
    const PARCEL_BOX = 'ParcelBox';
    const PARCEL_SHOP_1 = 'ParcelShop1';
    const ZABKA_POINT_2 = 'ZabkaPoint2';
    const P_BOX_3 = 'Pbox3';
    

    /** @var array */
    public static $list = [
        self::NONE,
        self::PARCEL_SHOP,
        self::ZABKA_POINT,
        self::PARCEL_BOX,
        self::PARCEL_SHOP_1,
        self::ZABKA_POINT_2,
        self::P_BOX_3
    ];
}