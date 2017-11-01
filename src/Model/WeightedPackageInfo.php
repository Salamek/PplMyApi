<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

class WeightedPackageInfo implements IWeightedPackageInfo
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
     * @inheritdoc
     */
    public function setWeight($weight)
    {
        if (!is_numeric($weight)) {
            throw new WrongDataException('$weight has wrong value');
        }
        $this->weight = $weight;
    }

    /**
     * @inheritdoc
     */
    public function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * @inheritdoc
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @inheritdoc
     */
    public function getRoutes()
    {
        return $this->routes;
    }


}