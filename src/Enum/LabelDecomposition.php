<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class LabelDecomposition
{
    const FULL = 1;
    const QUARTER = 4;

    /** @var array */
    public static $list = [
        self::FULL,
        self::QUARTER
    ];
}