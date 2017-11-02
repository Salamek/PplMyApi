<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi;

use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Model\IPackageNumberInfo;
use Salamek\PplMyApi\Model\PackageNumberInfo;


class Tools
{
    /**
     * @param IPackageNumberInfo $packageNumberInfo
     * @return string
     * @throws \Exception
     */
    public static function generatePackageNumber(IPackageNumberInfo $packageNumberInfo)
    {
        switch ($packageNumberInfo->getProductType()) {
            case Product::PRIVATE_PALETTE:
            case Product::PRIVATE_PALETTE_COD:
                $packageIdentifierPackageProductType = 5;
                break;

            case Product::PPL_PARCEL_CZ_PRIVATE:
            case Product::PPL_PARCEL_CZ_PRIVATE_COD:
                $packageIdentifierPackageProductType = 4;
                break;

            case Product::COMPANY_PALETTE:
            case Product::COMPANY_PALETTE_COD:
                $packageIdentifierPackageProductType = 9;
                break;

            case Product::PPL_PARCEL_CZ_BUSINESS:
            case Product::PPL_PARCEL_CZ_BUSINESS_COD:
                $packageIdentifierPackageProductType = 8;
                break;

            case Product::EXPORT_PACKAGE:
            case Product::EXPORT_PACKAGE_COD:
                $packageIdentifierPackageProductType = 2;
                break;

            case Product::PPL_PARCEL_CZ_AFTERNOON_PACKAGE:
            case Product::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD:
                $packageIdentifierPackageProductType = 3;
                break;

            default:
                throw new \Exception(sprintf('Unknown packageProductType "%s"', $packageNumberInfo->getProductType()));
                break;
        }

        $list = [
            $packageIdentifierPackageProductType,
            $packageNumberInfo->getDepoCode(),
            ($packageNumberInfo->isCod() ? '9' : '5'),
            0,
            str_pad($packageNumberInfo->getSeriesNumberId(), 6, '0', STR_PAD_LEFT)
        ];

        $identifier = implode('', $list);

        if (strlen($identifier) != 11) { //No control number
            throw new \Exception(sprintf('Failed to generate correct package id:%s', $identifier));
        }

        return $identifier;
    }

    /**
     * @param $packageNumber
     * @return null|PackageNumberInfo
     */
    public static function parsePackageNumber($packageNumber)
    {
        $packageProductTypes = [5, 4, 9, 8, 2, 3];
        $regex = '/^('.implode('|', $packageProductTypes).')('.implode('|', Depo::$list).')(\d{1})(\d{1})(\d{6})$/i';
        $matches = [];
        if (preg_match($regex, $packageNumber, $matches))
        {
            return new PackageNumberInfo($matches[5], $matches[1], $matches[2], $matches[3] == '9');
        }

        return null;
    }
}