<?php

declare(strict_types=1);

namespace Salamek\PplMyApi\Enum;

class AddressForService
{
    public const RETURN_ADDRESS_NORMAL_PACKAGE = 'BP';
    public const RETURN_ADDRESS_RETURN_PACKAGE = 'RETD';
    public const RETURN_ADDRESS_CONNECT_PACKAGE = 'RETC';

    /** @var array */
    public static $list = [
        self::RETURN_ADDRESS_NORMAL_PACKAGE,
        self::RETURN_ADDRESS_RETURN_PACKAGE,
        self::RETURN_ADDRESS_CONNECT_PACKAGE,
    ];
}