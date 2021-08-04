<?php
/**
 * Copyright (C) 2021 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


interface ICityRouting
{
    public function getRouteCode();

    public function getDepoCode();

    public function getHighlighted();

    public function setRouteCode($routeCode);

    public function setDepoCode($depoCode);

    public function setHighlighted($highlighted);
}