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
    public static $productTypeToPackageProductTypeMapping = [
        Product::PRIVATE_PALETTE => '5',
        
        Product::PPL_PARCEL_CZ_PRIVATE => '4',
        
        Product::COMPANY_PALETTE => '9',
        
        Product::PPL_PARCEL_CZ_BUSINESS => '8',
        
        Product::EXPORT_PACKAGE => '2',
        Product::PPL_PARCEL_CONNECT => '2',
        
        Product::PPL_PARCEL_CZ_AFTERNOON_PACKAGE => '3',
        
        Product::PPL_PARCEL_CZ_SMART => '7',
    ];
    
    public static $productTypeToPackageProductTypeMappingCod = [
        Product::PRIVATE_PALETTE_COD => '5',
        
        Product::PPL_PARCEL_CZ_PRIVATE_COD => '4',
        
        Product::COMPANY_PALETTE_COD => '9',
        
        Product::PPL_PARCEL_CZ_BUSINESS_COD => '8',
        
        Product::EXPORT_PACKAGE_COD => '2',
        Product::PPL_PARCEL_CONNECT_COD => '2',
        
        Product::PPL_PARCEL_CZ_AFTERNOON_PACKAGE_COD => '3',
        
        Product::PPL_PARCEL_CZ_SMART_COD => '7'
    ];
    
    /**
     * Returns cod pairs in array, true == COD
     * @param type $productType
     * @return type
     */
    public static function getCodPairs($productType) {
        if (in_array($productType, [Product::PPL_PARCEL_CZ_SMART, Product::PPL_PARCEL_CZ_SMART_COD])) {
            return [
                true => '8',
                false => '0'
            ];
        }
        
        return [
            true => '9',
            false => '5'
        ];
    }
    
    /**
     * @param IPackageNumberInfo $packageNumberInfo
     * @return string
     * @throws \Exception
     */
    public static function generatePackageNumber(IPackageNumberInfo $packageNumberInfo)
    {
        $bothArrays = array_replace(Tools::$productTypeToPackageProductTypeMapping, Tools::$productTypeToPackageProductTypeMappingCod);
        if (!array_key_exists($packageNumberInfo->getProductType(), $bothArrays)) {
            throw new \Exception(sprintf('Unknown packageProductType "%s"', $packageNumberInfo->getProductType()));
        }
        $packageIdentifierPackageProductType = $bothArrays[$packageNumberInfo->getProductType()];
        
        $list = [
            $packageIdentifierPackageProductType,
            $packageNumberInfo->getDepoCode(),
            Tools::getCodPairs($packageNumberInfo->getProductType())[$packageNumberInfo->isCod()],
            str_pad($packageNumberInfo->getSeriesNumberId(), 7, '0', STR_PAD_LEFT)
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
        $packageProductTypes = array_unique(array_values(Tools::$productTypeToPackageProductTypeMapping));
        $regex = '/^('.implode('|', $packageProductTypes).')('.implode('|', Depo::$list).')(\d{1})(\d{7})$/i';
        $matches = [];
        if (preg_match($regex, $packageNumber, $matches))
        {
            $reversedMappingArray = array_flip(Tools::$productTypeToPackageProductTypeMapping);
            if (!array_key_exists($matches[1], $reversedMappingArray)) {
                throw new \Exception(sprintf('Unknown parsed packageProductType "%s"', $matches[1]));
            }
            
            $reversedMappingArrayCod = array_flip(Tools::$productTypeToPackageProductTypeMappingCod);
            if (!array_key_exists($matches[1], $reversedMappingArrayCod)) {
                throw new \Exception(sprintf('Unknown parsed packageProductType "%s"', $matches[1]));
            }
            
            // Detect temporary product type to detect COD correctly
            $productType = $reversedMappingArray[$matches[1]];
            $codPairsReversed = array_flip(Tools::getCodPairs($productType));
            
            if (!array_key_exists($matches[3], $codPairsReversed)) {
                throw new \Exception(sprintf('COD identifier is unknown "%s"', $matches[3]));
            }
            
            $isCod = boolval($codPairsReversed[$matches[3]]);
            
            // Detect product type for real this time if COD
            if ($isCod) {
                $productType = $reversedMappingArrayCod[$matches[1]];
            }
            
            
            return new PackageNumberInfo($matches[4], $productType, $matches[2], $isCod);
        }

        return null;
    }
}
