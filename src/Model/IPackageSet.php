<?php
/**
 * Copyright (C) 2022 Adam Schubert <adam.schubert@sg1-game.net>.
 */


namespace Salamek\PplMyApi\Model;

/**
 * Description of IPackageSet
 *
 * @author sadam
 */
interface IPackageSet {
    
    /**
     * @param int $packageCount
     */
    public function setPackageCount(int $packageCount): void;

    /**
     * @param int $packagePosition
     */
    public function setPackagePosition(int $packagePosition): void;

    /**
     * 
     * @param string $masterPackageNumber
     */
    public function setMasterPackageNumber(string $masterPackageNumber): void;
    
    /**
     * @return int
     */
    public function getPackageCount(): int;

    /**
     * @return int
     */
    public function getPackagePosition(): int;
    
    /**
     * 
     * @return string|null
     */
    public function getMasterPackageNumber(): string;
}
