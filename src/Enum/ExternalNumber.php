<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class ExternalNumber
{
    const EXTERNAL = 'B2CO';
    const CUSTOMER = 'CUST';
    const PARTNER = 'PRTN';
    const JJD = 'CJJD';
    const AWB = 'CAWB';
    const TOAD = 'TOAD';
    const TOAD_ID = 'TDID';
    const TP_DKOD = 'DKOD';
    const PL_NUMBER = 'PLCE';
    const JJD_PARCEL_CONNECT = 'PJJD';

    /** @var array */
    public static $list = [
        self::EXTERNAL,
        self::CUSTOMER,
        self::PARTNER,
        self::JJD,
        self::AWB,
        self::TOAD,
        self::TOAD_ID,
        self::TP_DKOD,
        self::PL_NUMBER,
        self::JJD_PARCEL_CONNECT
    ];
}