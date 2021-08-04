<?php
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 8/5/21
 * Time: 1:16 AM
 */

namespace Salamek\PplMyApi\Model;


class CityRouting implements ICityRouting
{
    private $routeCode;

    private $depoCode;

    private $highlighted;

    /**
     * CityRouting constructor.
     * @param $routeCode
     * @param $depoCode
     * @param $highlighted
     */
    public function __construct($routeCode, $depoCode, $highlighted)
    {
        $this->routeCode = $routeCode;
        $this->depoCode = $depoCode;
        $this->highlighted = $highlighted;
    }


    public function getRouteCode()
    {
        return $this->routeCode;
    }

    public function getDepoCode()
    {
        return $this->depoCode;
    }

    public function getHighlighted()
    {
        return $this->highlighted;
    }

    public function setRouteCode($routeCode)
    {
        $this->routeCode = $routeCode;
    }

    public function setDepoCode($depoCode)
    {
        $this->depoCode = $depoCode;
    }

    public function setHighlighted($highlighted)
    {
        $this->highlighted = $highlighted;
    }

}