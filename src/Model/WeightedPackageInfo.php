<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

class WeightedPackageInfo
{
    /** @var float */
    private $weight;

    /** @var Route[] */
    private $routes = [];

    /**
     * WeightedPackageInfo constructor.
     * @param float $weight
     * @param Route[] $routes
     */
    public function __construct($weight, array $routes)
    {
        $this->setWeight($weight);
        $this->setRoutes($routes);
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
     * @param Route[] $routes
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }


}