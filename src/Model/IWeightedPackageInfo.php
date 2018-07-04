<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IWeightedPackageInfo
 * @package Salamek\PplMyApi\Model
 */
interface IWeightedPackageInfo
{
    /**
     * @param float $weight
     * @throws WrongDataException
     */
    public function setWeight($weight);

    /**
     * @param Route[] $routes
     */
    public function setRoutes(array $routes);

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @return Route[]
     */
    public function getRoutes();
}