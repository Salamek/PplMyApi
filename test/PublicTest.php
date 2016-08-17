<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */


use Salamek\PplMyApi\Tools;

final class PublicTest extends BaseTest
{
    /**
     * @test
     */
    public function testIsHealthy()
    {
        $this->assertInternalType('boolean', $this->pplMyApi->isHealthy());
    }

    /**
     * @test
     */
    public function testGetVersion()
    {
        $this->assertRegExp('/^\d\.\d\.\d\.\d$/', $this->pplMyApi->getVersion());
    }

    /**
     * @test
     */
    public function testPackageNumber()
    {
        $this->assertEquals('40950000115', $this->package->getPackageNumber());
    }

    /**
     * @test
     */
    public function testGeneratePackageNumber()
    {
        $this->package->setSeriesNumberId(114);
        $this->assertEquals('40950000114', Tools::generatePackageNumber($this->package));
    }

    /**
     * @test
     * @throws Exception
     */
    public function testGetParcelShops()
    {
        $this->assertNotEmpty($this->pplMyApi->getParcelShops());
    }

    /**
     * @test
     */
    public function testgetSprintRoutes()
    {
        $this->assertNotEmpty($this->pplMyApi->getSprintRoutes());
    }
}