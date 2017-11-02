<?php
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 2.11.17
 * Time: 15:58
 */

namespace Salamek\PplMyApi\Model;


class PackageNumberInfo implements IPackageNumberInfo
{
    /** @var int */
    private $productType;

    /** @var string */
    private $depoCode;

    /** @var int */
    private $seriesNumberId;

    /** @var bool */
    private $isCod;

    /**
     * PackageNumberInfo constructor.
     * @param $seriesNumberId integer
     * @param $productType integer
     * @param $depoCode string
     * @param $isCod boolean
     */
    public function __construct($seriesNumberId, $productType, $depoCode, $isCod)
    {
        $this->productType = $productType;
        $this->depoCode = $depoCode;
        $this->seriesNumberId = $seriesNumberId;
        $this->isCod = $isCod;
    }

    /**
     * @param int $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return int
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param string $depoCode
     */
    public function setDepoCode($depoCode)
    {
        $this->depoCode = $depoCode;
    }

    /**
     * @return string
     */
    public function getDepoCode()
    {
        return $this->depoCode;
    }

    /**
     * @param int $seriesNumberId
     */
    public function setSeriesNumberId($seriesNumberId)
    {
        $this->seriesNumberId = $seriesNumberId;
    }

    /**
     * @return int
     */
    public function getSeriesNumberId()
    {
        return $this->seriesNumberId;
    }

    /**
     * @param bool $isCod
     */
    public function setIsCod($isCod)
    {
        $this->isCod = $isCod;
    }

    /**
     * @return bool
     */
    public function isCod()
    {
        return $this->isCod;
    }
}