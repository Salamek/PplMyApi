<?php

/**
 * Copyright (C) 2022 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

/**
 * Description of PackageSet
 *
 * @author Adam Schubert
 */
class PackageSet implements IPackageSet {
    
    /**
     * @var string
     */
    private $masterPackageNumber;
    
    /**
     * @var int
     */
    private $packageCount;
    
    /**
     * @var int
     */
    private $packagePosition;
    
    /**
     * @param string $masterPackageNumber
     * @param int $packagePosition
     * @param int $packageCount
     */
    public function __construct(string $masterPackageNumber, int $packagePosition = 1, int $packageCount = 1) {
        $this->masterPackageNumber = $masterPackageNumber;
        $this->packageCount = $packageCount;
        $this->packagePosition = $packagePosition;
    }

    /**
     * @param int $packageCount
     */
    public function setPackageCount(int $packageCount): void
    {
        $this->packageCount = $packageCount;
    }

    /**
     * @param int $packagePosition
     */
    public function setPackagePosition(int $packagePosition): void
    {
        $this->packagePosition = $packagePosition;
    }

    /**
     * @param string $masterPackageNumber
     */
    public function setMasterPackageNumber(string $masterPackageNumber): void {
        $this->masterPackageNumber = $masterPackageNumber;
    }
    
    /**
     * @return int
     */
    public function getPackageCount(): int
    {
        return $this->packageCount;
    }

    /**
     * @return int
     */
    public function getPackagePosition(): int
    {
        return $this->packagePosition;
    }
    
    /**
     * @return string|null
     */
    public function getMasterPackageNumber(): string {
        return $this->masterPackageNumber;
    }
}
