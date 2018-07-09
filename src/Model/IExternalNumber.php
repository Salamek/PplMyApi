<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IExternalNumber
 * @package Salamek\PplMyApi\Model
 */
interface IExternalNumber
{
    /**
     * @param string $code
     */
    public function setCode($code);

    /**
     * @param string $externalNumber
     * @throws WrongDataException
     */
    public function setExternalNumber($externalNumber);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getExternalNumber();
}
