<?php

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
final class PrivateTest extends BaseTest
{
    /**
     * @test
     * @throws Exception
     */
    public function testGetPackages()
    {
        if ($this->anonymous) {
            $this->markTestSkipped('No login credentials has been set.');
        }

        $dateFrom = new \DateTime();
        $dateFrom->modify('-2 days');

        $this->assertNotEmpty($this->pplMyApi->getPackages(null, $dateFrom));
    }

    /**
     * @test
     * @throws Exception
     */
    public function testGetCitiesRouting()
    {
        if ($this->anonymous) {
            $this->markTestSkipped('No login credentials has been set.');
        }

        $this->assertNotEmpty($this->pplMyApi->getCitiesRouting());
    }

    /**
     * @test
     */
    public function testCreateOrders()
    {
        if ($this->anonymous) {
            $this->markTestSkipped('No login credentials has been set.');
        }

        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @test
     */
    public function testCreatePackages()
    {
        if ($this->anonymous) {
            $this->markTestSkipped('No login credentials has been set.');
        }

        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @test
     */
    public function testCreatePickupOrders()
    {
        if ($this->anonymous) {
            $this->markTestSkipped('No login credentials has been set.');
        }

        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}