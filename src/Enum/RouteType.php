<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class RouteType
{
    const IN = 'IN';
    const OUT = 'OUT';
    const OUT_SD = 'OUT_SD';

    /** @var array */
    public static $list = [
        self::IN,
        self::OUT,
        self::OUT_SD
    ];
}