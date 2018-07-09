<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IPalletInfo
 * @package Salamek\PplMyApi\Model
 */
interface IPalletInfo
{
    /**
     * @param Colli[] $collies
     * @throws WrongDataException
     */
    public function setCollies($collies);

    /**
     * @param int $manipulationType
     * @throws WrongDataException
     */
    public function setManipulationType($manipulationType);

    /**
     * @param int $palletEurCount
     * @throws WrongDataException
     */
    public function setPalletEurCount($palletEurCount);

    /**
     * @param null|string $packDescription
     * @throws WrongDataException
     */
    public function setPackDescription($packDescription);

    /**
     * @param int|null $pickUpCargoTypeCode
     * @throws WrongDataException
     */
    public function setPickUpCargoTypeCode($pickUpCargoTypeCode);

    /**
     * @param float|null $volume
     * @throws WrongDataException
     */
    public function setVolume($volume);

    /**
     * @return Colli[]
     */
    public function getCollies();


    /**
     * @return int
     */
    public function getManipulationType();

    /**
     * @return int
     */
    public function getPalletEurCount();

    /**
     * @return null|string
     */
    public function getPackDescription();

    /**
     * @return int|null
     */
    public function getPickUpCargoTypeCode();

    /**
     * @return float|null
     */
    public function getVolume();
}
