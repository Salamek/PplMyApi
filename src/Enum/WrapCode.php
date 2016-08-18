<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class WrapCode
{
    const PACKAGE = 32;
    const CRATE = 33;
    const DRUM = 34;
    const CARTON = 35;
    const CONTAINER = 36;
    const DISC = 37;
    const BOX = 38;
    const PALETTE = 39;
    const PALETTE_EUR = 40;
    const BAG = 41;
    const BARREL = 42;
    const FREE = 43;
    const COLLI = 44;
    const VOLUME = 45;
    const ROD = 46;
    const ROLL = 47;
    const PLASTIC_BOX = 50;
    const ENVELOPE_PL = 54;

    /** @var array */
    public static $list = [
        self::PACKAGE,
        self::CRATE,
        self::DRUM,
        self::CARTON,
        self::CONTAINER,
        self::DISC,
        self::BOX,
        self::PALETTE,
        self::PALETTE_EUR,
        self::BAG,
        self::BARREL,
        self::FREE,
        self::COLLI,
        self::VOLUME,
        self::ROD,
        self::ROLL,
        self::PLASTIC_BOX,
        self::ENVELOPE_PL
    ];
}