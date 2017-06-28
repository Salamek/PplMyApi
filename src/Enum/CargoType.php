<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class CargoType
{
    const DEPO = 'PT';
    const STANDARD = 'SV';

    /** @var array */
    public static $list = [
        self::DEPO,
        self::STANDARD
    ];
}