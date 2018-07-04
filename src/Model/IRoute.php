<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IRoute
 * @package Salamek\PplMyApi\Model
 */
interface IRoute
{
    /**
     * @param string $routeType
     * @throws WrongDataException
     */
    public function setRouteType($routeType);

    /**
     * @param string $routeCode
     */
    public function setRouteCode($routeCode);

    /**
     * @return string
     */
    public function getRouteType();

    /**
     * @return string
     */
    public function getRouteCode();
}