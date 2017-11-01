<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\WrapCode;
use Salamek\PplMyApi\Exception\WrongDataException;

class Colli implements IColli
{
    /** @var string */
    private $colliNumber;

    /** @var integer */
    private $width = null;

    /** @var integer */
    private $height = null;

    /** @var integer */
    private $length = null;

    /** @var float */
    private $weight;

    /** @var string */
    private $wrapCode;

    /**
     * PackageInColli constructor.
     * @param string $colliNumber
     * @param int $width
     * @param int $height
     * @param int $length
     * @param float $weight
     * @param string $wrapCode
     */
    public function __construct($colliNumber, $weight, $wrapCode, $width = null, $height = null, $length = null)
    {
        $this->colliNumber = $colliNumber;
        $this->width = $width;
        $this->height = $height;
        $this->length = $length;
        $this->weight = $weight;
        $this->wrapCode = $wrapCode;
    }

    /**
     * @param string $colliNumber
     * @throws WrongDataException
     */
    public function setColliNumber($colliNumber)
    {
        if (mb_strlen($colliNumber) > 50) {
            throw new WrongDataException('$colliNumber is longer than 50');
        }
        $this->colliNumber = $colliNumber;
    }

    /**
     * @param int $width
     * @throws WrongDataException
     */
    public function setWidth($width)
    {
        if (!is_null($width) && !is_numeric($width)) {
            throw new WrongDataException('$width has wrong value');
        }
        $this->width = $width;
    }

    /**
     * @param int $height
     * @throws WrongDataException
     */
    public function setHeight($height)
    {
        if (!is_null($height) && !is_numeric($height)) {
            throw new WrongDataException('$height has wrong value');
        }
        $this->height = $height;
    }

    /**
     * @param int $length
     * @throws WrongDataException
     */
    public function setLength($length)
    {
        if (!is_null($length) && !is_numeric($length)) {
            throw new WrongDataException('$length has wrong value');
        }
        $this->length = $length;
    }

    /**
     * @param float $weight
     * @throws WrongDataException
     */
    public function setWeight($weight)
    {
        if (!is_numeric($weight)) {
            throw new WrongDataException('$weight has wrong value');
        }
        $this->weight = $weight;
    }

    /**
     * @param string $wrapCode
     * @throws WrongDataException
     */
    public function setWrapCode($wrapCode)
    {
        if (!in_array($wrapCode, WrapCode::$list)) {
            throw new WrongDataException(sprintf('$wrapCode has wrong value, only %s are allowed', implode(', ', WrapCode::$list)));
        }
        $this->wrapCode = $wrapCode;
    }

    /**
     * @return string
     */
    public function getColliNumber()
    {
        return $this->colliNumber;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getWrapCode()
    {
        return $this->wrapCode;
    }
}
