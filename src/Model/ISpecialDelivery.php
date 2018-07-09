<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

/**
 * Interface ISpecialDelivery
 * @package Salamek\PplMyApi\Model
 */
interface ISpecialDelivery
{
    /**
     * @param $parcelShopCode
     */
    public function setParcelShopCode($parcelShopCode);

    /**
     * @param \DateTimeInterface $deliveryDate
     */
    public function setDeliveryDate(\DateTimeInterface $deliveryDate);

    /**
     * @param \DateTimeInterface $deliveryTimeFrom
     */
    public function setDeliveryTimeFrom(\DateTimeInterface $deliveryTimeFrom);

    /**
     * @param \DateTimeInterface $deliveryTimeTo
     */
    public function setDeliveryTimeTo(\DateTimeInterface $deliveryTimeTo);

    /**
     * @param \DateTimeInterface $takeDate
     */
    public function setTakeDate(\DateTimeInterface $takeDate);

    /**
     * @param \DateTimeInterface $takeTimeFrom
     */
    public function setTakeTimeFrom(\DateTimeInterface $takeTimeFrom);

    /**
     * @param \DateTimeInterface $takeTimeTo
     */
    public function setTakeTimeTo(\DateTimeInterface $takeTimeTo);

    /**
     * @return null|string
     */
    public function getParcelShopCode();

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryDate();

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryTimeFrom();

    /**
     * @return \DateTimeInterface|null
     */
    public function getDeliveryTimeTo();

    /**
     * @return \DateTimeInterface|null
     */
    public function getTakeDate();

    /**
     * @return \DateTimeInterface|null
     */
    public function getTakeTimeFrom();

    /**
     * @return \DateTimeInterface|null
     */
    public function getTakeTimeTo();
}
