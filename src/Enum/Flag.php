<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class Flag
{
    const SATURDAY_DELIVERY = 'SD';

    /** @var array */
    public static $list = [
        self::SATURDAY_DELIVERY
    ];
}