<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\RouteType;
use Salamek\PplMyApi\Exception\WrongDataException;

class Route
{
    /** @var string */
    private $routeType;

    /** @var string */
    private $routeCode;

    /**
     * Route constructor.
     * @param string $routeType
     * @param string $routeCode
     */
    public function __construct($routeType, $routeCode)
    {
        $this->setRouteType($routeType);
        $this->setRouteCode($routeCode);
    }

    /**
     * @param string $routeType
     * @throws WrongDataException
     */
    public function setRouteType($routeType)
    {
        if (!in_array($routeType, RouteType::$list))
        {
            throw new WrongDataException(sprintf('$routeType has wrong value, only %s are allowed', implode(', ', RouteType::$list)));
        }
        $this->routeType = $routeType;
    }

    /**
     * @param string $routeCode
     */
    public function setRouteCode($routeCode)
    {
        $this->routeCode = $routeCode;
    }

    /**
     * @return string
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * @return string
     */
    public function getRouteCode()
    {
        return $this->routeCode;
    }
}