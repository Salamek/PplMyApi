<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi;

use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Model\IPackage;


class Tools
{
    /**
     * @param IPackage $package
     * @return mixed
     * @throws \Exception
     */
    public static function generatePackageNumber(IPackage $package)
    {
        if (!$package->getSeriesNumberId()) {
            throw new WrongDataException('Package has no Series number ID!');
        }

        switch ($package->getPackageProductType()) {
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
                throw new \Exception(sprintf('Unknown packageProductType "%s"', $package->getPackageProductType()));
                break;
        }

        $list = [
            $packageIdentifierPackageProductType,
            $package->getDepoCode(),
            (in_array($package->getPackageProductType(), Product::$cashOnDelivery) ? '9' : '5'),
            0,
            str_pad($package->getSeriesNumberId(), 6, '0', STR_PAD_LEFT)
        ];

        $identifier = implode('', $list);

        if (strlen($identifier) != 11) { //No control number
            throw new \Exception(sprintf('Failed to generate correct package id:%s', $identifier));
        }

        return $identifier;
    }
}