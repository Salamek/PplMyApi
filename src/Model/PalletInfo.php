<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\ManipulationType;
use Salamek\PplMyApi\Enum\CargoType;
use Salamek\PplMyApi\Exception\WrongDataException;

class PalletInfo
{
    /** @var Colli[] */
    private $collies = [];

    /** @var null|integer */
    private $manipulationType = null;

    /** @var null|integer */
    private $palletEurCount = null;

    /** @var null|string */
    private $packDescription = null;

    /** @var null|integer */
    private $pickUpCargoTypeCode = null;

    /** @var null|float */
    private $volume = null;

    /**
     * PalletInfo constructor.
     * @param Colli[] $collies
     * @param int|null $manipulationType
     * @param int|null $palletEurCount
     * @param null|string $packDescription
     * @param int|null $pickUpCargoTypeCode
     * @param float|null $volume
     */
    public function __construct(array $collies, $manipulationType = null, $palletEurCount = null, $packDescription = null, $pickUpCargoTypeCode = null, $volume = null)
    {
        $this->setCollies($collies);
        $this->setManipulationType($manipulationType);
        $this->setPalletEurCount($palletEurCount);
        $this->setPackDescription($packDescription);
        $this->setPickUpCargoTypeCode($pickUpCargoTypeCode);
        $this->setVolume($volume);
    }


    /**
     * @param Colli[] $collies
     * @throws WrongDataException
     */
    public function setCollies($collies)
    {
        $this->collies = $collies;
    }

    /**
     * @param int $manipulationType
     * @throws WrongDataException
     */
    public function setManipulationType($manipulationType)
    {
        if (!in_array($manipulationType, ManipulationType::$list)) {
            throw new WrongDataException(sprintf('$manipulationType has wrong value, only %s are allowed', implode(', ', ManipulationType::$list)));
        }

        $this->manipulationType = $manipulationType;
    }

    /**
     * @param int $palletEurCount
     * @throws WrongDataException
     */
    public function setPalletEurCount($palletEurCount)
    {
        if (!is_numeric($palletEurCount)) {
            throw new WrongDataException('$paletteEurCount have wrong value');
        }
        $this->palletEurCount = $palletEurCount;
    }

    /**
     * @param null|string $packDescription
     * @throws WrongDataException
     */
    public function setPackDescription($packDescription)
    {
        if (mb_strlen($packDescription) > 512) {
            throw new WrongDataException('$packDescription is longer than 512');
        }
        $this->packDescription = $packDescription;
    }

    /**
     * @param int|null $pickUpCargoTypeCode
     * @throws WrongDataException
     */
    public function setPickUpCargoTypeCode($pickUpCargoTypeCode)
    {
        if (!in_array($pickUpCargoTypeCode, CargoType::$list)) {
            throw new WrongDataException(sprintf('$pickUpCargoTypeCode has wrong value, only %s are allowed', implode(', ', CargoType::$list)));
        }
        $this->pickUpCargoTypeCode = $pickUpCargoTypeCode;
    }

    /**
     * @param float|null $volume
     * @throws WrongDataException
     */
    public function setVolume($volume)
    {
        if (!is_numeric($volume)) {
            throw new WrongDataException('$volume has wrong value');
        }
        $this->volume = $volume;
    }

    /**
     * @return Colli[]
     */
    public function getCollies()
    {
        return $this->collies;
    }


    /**
     * @return int
     */
    public function getManipulationType()
    {
        return $this->manipulationType;
    }

    /**
     * @return int
     */
    public function getPalletEurCount()
    {
        return $this->palletEurCount;
    }

    /**
     * @return null|string
     */
    public function getPackDescription()
    {
        return $this->packDescription;
    }

    /**
     * @return int|null
     */
    public function getPickUpCargoTypeCode()
    {
        return $this->pickUpCargoTypeCode;
    }

    /**
     * @return float|null
     */
    public function getVolume()
    {
        return $this->volume;
    }
}
