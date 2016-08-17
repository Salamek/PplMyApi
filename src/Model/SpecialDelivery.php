<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

/**
 * Class SpecialDelivery
 * @package Salamek\MyApi
 */
class SpecialDelivery
{
    /** @var null|string */
    private $parcelShopCode = null;

    /** @var null|\DateTimeInterface */
    private $deliveryDate = null;

    /** @var null|\DateTimeInterface */
    private $deliveryTimeFrom = null;

    /** @var null|\DateTimeInterface */
    private $deliveryTimeTo = null;

    /** @var \DateTimeInterface */
    private $takeDate;

    /** @var null|\DateTimeInterface */
    private $takeTimeFrom = null;

    /** @var null|\DateTimeInterface */
    private $takeTimeTo = null;

    /**
     * SpecialDelivery constructor.
     * @param null|string $parcelShopCode
     * @param \DateTimeInterface|null $deliveryDate
     * @param \DateTimeInterface|null $deliveryTimeFrom
     * @param \DateTimeInterface|null $deliveryTimeTo
     * @param \DateTimeInterface $takeDate
     * @param \DateTimeInterface|null $takeTimeFrom
     * @param \DateTimeInterface|null $takeTimeTo
     */
    public function __construct($parcelShopCode, \DateTimeInterface $deliveryDate = null, \DateTimeInterface $deliveryTimeFrom = null, \DateTimeInterface $deliveryTimeTo = null, \DateTimeInterface $takeDate = null, \DateTimeInterface $takeTimeFrom = null, \DateTimeInterface $takeTimeTo = null)
    {
        $this->parcelShopCode = $parcelShopCode;
        $this->deliveryDate = $deliveryDate;
        $this->deliveryTimeFrom = $deliveryTimeFrom;
        $this->deliveryTimeTo = $deliveryTimeTo;
        $this->takeDate = $takeDate;
        $this->takeTimeFrom = $takeTimeFrom;
        $this->takeTimeTo = $takeTimeTo;
    }
    
    /**
     * @param $parcelShopCode
     */
    public function setParcelShopCode($parcelShopCode)
    {
        $this->parcelShopCode = $parcelShopCode;
    }

    /**
     * @param \DateTimeInterface $deliveryDate
     */
    public function setDeliveryDate(\DateTimeInterface $deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @param \DateTimeInterface $deliveryTimeFrom
     */
    public function setDeliveryTimeFrom(\DateTimeInterface $deliveryTimeFrom)
    {
        $this->deliveryTimeFrom = $deliveryTimeFrom;
    }

    /**
     * @param \DateTimeInterface $deliveryTimeTo
     */
    public function setDeliveryTimeTo(\DateTimeInterface $deliveryTimeTo)
    {
        $this->deliveryTimeTo = $deliveryTimeTo;
    }

    /**
     * @param \DateTimeInterface $takeDate
     */
    public function setTakeDate(\DateTimeInterface $takeDate)
    {
        $this->takeDate = $takeDate;
    }

    /**
     * @param \DateTimeInterface $takeTimeFrom
     */
    public function setTakeTimeFrom(\DateTimeInterface $takeTimeFrom)
    {
        $this->takeTimeFrom = $takeTimeFrom;
    }

    /**
     * @param \DateTimeInterface $takeTimeTo
     */
    public function setTakeTimeTo(\DateTimeInterface $takeTimeTo)
    {
        $this->takeTimeTo = $takeTimeTo;
    }

    /**
     * @return null|string
     */
    public function getParcelShopCode()
    {
        return $this->parcelShopCode;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryTimeFrom()
    {
        return $this->deliveryTimeFrom;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryTimeTo()
    {
        return $this->deliveryTimeTo;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTakeDate()
    {
        return $this->takeDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTakeTimeFrom()
    {
        return $this->takeTimeFrom;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTakeTimeTo()
    {
        return $this->takeTimeTo;
    }
}