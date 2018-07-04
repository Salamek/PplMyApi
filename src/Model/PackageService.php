<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\PackageService as PackageServiceEnum;
use Salamek\PplMyApi\Exception\WrongDataException;

class PackageService implements IPackageService
{
    /** @var string */
    protected $svcCode;

    /**
     * PackageServices constructor.
     * @param string $svcCode
     */
    public function __construct($svcCode)
    {
        $this->setSvcCode($svcCode);
    }

    /**
     * @param string $svcCode
     * @throws WrongDataException
     */
    public function setSvcCode($svcCode)
    {
        if (!in_array($svcCode, PackageServiceEnum::$list)) {
            throw new WrongDataException(sprintf('$svcCode has wrong value, only %s are allowed', implode(', ', PackageServiceEnum::$list)));
        }

        $this->svcCode = $svcCode;
    }

    /**
     * @return string
     */
    public function getSvcCode()
    {
        return $this->svcCode;
    }

    /**
     * @param IPackage $package
     * @return array
     */
    public static function packageServicesToArray(IPackage $package)
    {
        $return = [];
        foreach ($package->getPackageServices() AS $packageService) {
            $return[] = $packageService->getSvcCode();
        }

        return $return;
    }
}