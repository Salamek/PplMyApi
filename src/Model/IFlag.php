<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IFlag
 * @package Salamek\PplMyApi\Model
 */
interface IFlag
{
    /**
     * @param string $code
     * @throws WrongDataException
     */
    public function setCode($code);

    /**
     * @param boolean $value
     * @throws WrongDataException
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return boolean
     */
    public function isValue();
}