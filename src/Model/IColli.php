<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IColli
 * @package Salamek\PplMyApi\Model
 */
interface IColli
{
    /**
     * @param string $colliNumber
     * @throws WrongDataException
     */
    public function setColliNumber($colliNumber);

    /**
     * @param int $width
     * @throws WrongDataException
     */
    public function setWidth($width);

    /**
     * @param int $height
     * @throws WrongDataException
     */
    public function setHeight($height);

    /**
     * @param int $length
     * @throws WrongDataException
     */
    public function setLength($length);

    /**
     * @param float $weight
     * @throws WrongDataException
     */
    public function setWeight($weight);

    /**
     * @param string $wrapCode
     * @throws WrongDataException
     */
    public function setWrapCode($wrapCode);

    /**
     * @return string
     */
    public function getColliNumber();

    /**
     * @return int
     */
    public function getWidth();

    /**
     * @return int
     */
    public function getHeight();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @return string
     */
    public function getWrapCode();
}
