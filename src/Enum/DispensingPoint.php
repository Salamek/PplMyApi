<?php
/**
 * Copyright (C) 2022 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class DispensingPoint
{
    const PARCEL_SHOP = 'ParcelShop';
    const PARCEL_BOX = 'ParcelBox';
    const ZABKA_POINT = 'Zabkapoint';

    /** @var array */
    public static $list = [
        self::PARCEL_SHOP,
        self::PARCEL_BOX,
        self::ZABKA_POINT
    ];

}
