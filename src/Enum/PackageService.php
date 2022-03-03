<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Enum;


class PackageService
{
    const CASH_ON_DELIVERY = 'COD'; // Ignored, spedified by PaymentInfo
    const EVENING_DELIVERY = 'ED';
    const CASH_PAYMENT = 'EXW';
    const INSURANCE = 'INSR'; // Ignored, spedified by PaymentInfo
    const MORNING_DELIVERY = 'MD';
    const AGE_CHECK_15_UP = 'A15';
    const AGE_CHECK_18_UP = 'A18';
    const PICKUP_BY_DRIVER = 'PUBC';
    const ANOTHER_DELIVERY_ATTEMPT = 'DPOD';
    
    // These are not in DOCs anymore, but keeping them for now for reference...
    /*const P_EUR_BACK = 'EB';
    const PERSONAL_COLLECTION = 'PPCK';
    const DOCUMENTS_BACK = 'DB';
    const YIELD_ON_THE_FLOOR = 'FH';
    const REMOVAL_OF_OLD_APPLIANCES = 'OGB';
    const SATURDAY_DELIVERY = 'SD';
    const ADR = 'ADR';*/

    public static $list = [
        self::CASH_ON_DELIVERY,
        self::EVENING_DELIVERY,
        self::CASH_PAYMENT,
        self::INSURANCE,
        self::MORNING_DELIVERY,
        self::AGE_CHECK_15_UP,
        self::AGE_CHECK_18_UP,
        self::PICKUP_BY_DRIVER,
        self::ANOTHER_DELIVERY_ATTEMPT,
        /*
        self::P_EUR_BACK,
        self::PERSONAL_COLLECTION,
        self::DOCUMENTS_BACK,
        self::YIELD_ON_THE_FLOOR,
        self::REMOVAL_OF_OLD_APPLIANCES,
        self::SATURDAY_DELIVERY,
        self::ADR*/
    ];
}