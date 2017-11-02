<?php
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 2.11.17
 * Time: 15:51
 */

namespace Salamek\PplMyApi\Model;

/**
 * Interface IPackageNumberInfo
 * @package Salamek\PplMyApi\Model
 */
interface IPackageNumberInfo
{
    /**
     * @param $productType integer
     * @return void
     */
    public function setProductType($productType);

    /**
     * @return integer
     */
    public function getProductType();

    /**
     * @param $depoCode string
     * @return void
     */
    public function setDepoCode($depoCode);

    /**
     * @return string
     */
    public function getDepoCode();

    /**
     * @param $seriesNumberId integer
     * @return void
     */
    public function setSeriesNumberId($seriesNumberId);

    /**
     * @return integer
     */
    public function getSeriesNumberId();

    /**
     * @param $isCod boolean
     * @return void
     */
    public function setIsCod($isCod);

    /**
     * @return boolean
     */
    public function isCod();
}