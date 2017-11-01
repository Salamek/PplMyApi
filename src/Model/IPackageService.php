<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IPackageService
 * @package Salamek\PplMyApi\Model
 */
interface IPackageService
{
    /**
     * @param string $svcCode
     * @throws WrongDataException
     */
    public function setSvcCode($svcCode);

    /**
     * @return string
     */
    public function getSvcCode();
}