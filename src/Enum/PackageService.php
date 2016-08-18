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
    const ADR = 'ADR';
    const INSURANCE = 'INSR'; // Ignored, spedified by PaymentInfo
    const P_EUR_BACK = 'EB';
    const PERSONAL_COLLECTION = 'PPCK';
    const DOCUMENTS_BACK = 'DB';
    const YIELD_ON_THE_FLOOR = 'FH';
    const REMOVAL_OF_OLD_APPLIANCES = 'OGB';
    const SATURDAY_DELIVERY = 'SD';

    public static $list = [
        self::CASH_ON_DELIVERY,
        self::EVENING_DELIVERY,
        self::CASH_PAYMENT,
        self::ADR,
        self::INSURANCE,
        self::P_EUR_BACK,
        self::PERSONAL_COLLECTION,
        self::DOCUMENTS_BACK,
        self::YIELD_ON_THE_FLOOR,
        self::REMOVAL_OF_OLD_APPLIANCES,
        self::SATURDAY_DELIVERY
    ];
}