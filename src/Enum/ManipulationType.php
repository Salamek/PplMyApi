<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class ManipulationType
{
    const CART = 1;
    const HYDRAULIC_LIFT = 2;

    /** @var array */
    public static $list = [
        self::CART,
        self::HYDRAULIC_LIFT
    ];
}