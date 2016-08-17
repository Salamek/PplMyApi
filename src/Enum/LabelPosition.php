<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class LabelPosition
{
    const TOP_LEFT = 1;
    const TOP_RIGHT = 2;
    const BOTTOM_LEFT = 3;
    const BOTTOM_RIGHT = 4;

    /** @var array  */
    public static $list = [
        self::TOP_LEFT,
        self::TOP_RIGHT,
        self::BOTTOM_LEFT,
        self::BOTTOM_RIGHT
    ];
}