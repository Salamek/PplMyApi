<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

/**
 * Class SpecialDelivery
 * @package Salamek\MyApi
 */
class SpecialDelivery implements ISpecialDelivery
{
    /** @var null|string */
    private $parcelShopCode;

    /** @var null|\DateTimeInterface */
    private $deliveryDate;

    /** @var null|\DateTimeInterface */
    private $deliveryTimeFrom;

    /** @var null|\DateTimeInterface */
    private $deliveryTimeTo;

    /** @var null|\DateTimeInterface */
    private $takeDate;

    /** @var null|\DateTimeInterface */
    private $takeTimeFrom;

    /** @var null|\DateTimeInterface */
    private $takeTimeTo;

    /**
     * SpecialDelivery constructor.
     * @param null|string               $parcelShopCode
     * @param \DateTimeInterface|null   $deliveryDate
     * @param \DateTimeInterface|null   $deliveryTimeFrom
     * @param \DateTimeInterface|null   $deliveryTimeTo
     * @param \DateTimeInterface|null   $takeDate
     * @param \DateTimeInterface|null   $takeTimeFrom
     * @param \DateTimeInterface|null   $takeTimeTo
     */
    public function __construct(
        $parcelShopCode,
        \DateTimeInterface $deliveryDate = null,
        \DateTimeInterface $deliveryTimeFrom = null,
        \DateTimeInterface $deliveryTimeTo = null,
        \DateTimeInterface $takeDate = null,
        \DateTimeInterface $takeTimeFrom = null,
        \DateTimeInterface $takeTimeTo = null
    ) {
        $this->parcelShopCode = $parcelShopCode;
        $this->deliveryDate = $deliveryDate;
        $this->deliveryTimeFrom = $deliveryTimeFrom;
        $this->deliveryTimeTo = $deliveryTimeTo;
        $this->takeDate = $takeDate;
        $this->takeTimeFrom = $takeTimeFrom;
        $this->takeTimeTo = $takeTimeTo;
    }

    /**
     * @inheritdoc
     */
    public function setParcelShopCode($parcelShopCode)
    {
        $this->parcelShopCode = $parcelShopCode;
    }

    /**
     * @inheritdoc
     */
    public function setDeliveryDate(\DateTimeInterface $deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @inheritdoc
     */
    public function setDeliveryTimeFrom(\DateTimeInterface $deliveryTimeFrom)
    {
        $this->deliveryTimeFrom = $deliveryTimeFrom;
    }

    /**
     * @inheritdoc
     */
    public function setDeliveryTimeTo(\DateTimeInterface $deliveryTimeTo)
    {
        $this->deliveryTimeTo = $deliveryTimeTo;
    }

    /**
     * @inheritdoc
     */
    public function setTakeDate(\DateTimeInterface $takeDate)
    {
        $this->takeDate = $takeDate;
    }

    /**
     * @inheritdoc
     */
    public function setTakeTimeFrom(\DateTimeInterface $takeTimeFrom)
    {
        $this->takeTimeFrom = $takeTimeFrom;
    }

    /**
     * @inheritdoc
     */
    public function setTakeTimeTo(\DateTimeInterface $takeTimeTo)
    {
        $this->takeTimeTo = $takeTimeTo;
    }

    /**
     * @inheritdoc
     */
    public function getParcelShopCode()
    {
        return $this->parcelShopCode;
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryTimeFrom()
    {
        return $this->deliveryTimeFrom;
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryTimeTo()
    {
        return $this->deliveryTimeTo;
    }

    /**
     * @inheritdoc
     */
    public function getTakeDate()
    {
        return $this->takeDate;
    }

    /**
     * @inheritdoc
     */
    public function getTakeTimeFrom()
    {
        return $this->takeTimeFrom;
    }

    /**
     * @inheritdoc
     */
    public function getTakeTimeTo()
    {
        return $this->takeTimeTo;
    }
}
