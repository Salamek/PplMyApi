<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */


use Salamek\PplMyApi\Enum\LabelDecomposition;
use Salamek\PplMyApi\Model\Package;
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
    public function testGetSprintRoutes()
    {
        $this->assertNotEmpty($this->pplMyApi->getSprintRoutes());
    }

    /**
     * @test
     */
    public function testGeneratePdfFullSinglePackage()
    {
        $raw = $this->pplMyApi->getLabels([$this->package], LabelDecomposition::FULL);

        $this->assertNotEmpty($raw);

        $filePath = __DIR__ . '/../tmp/' . $this->package->getPackageNumber() . '-full.pdf';

        file_put_contents($filePath, $raw);

        $this->assertFileExists($filePath);
    }

    /**
     * @test
     */
    public function testGeneratePdfFullMultiplePackages()
    {
        $raw = $this->pplMyApi->getLabels($this->packages, LabelDecomposition::FULL);

        $this->assertNotEmpty($raw);

        $packageNumbers = [];

        /** @var Package $package */
        foreach ($this->packages AS $package) {
            $packageNumbers[] = $package->getPackageNumber();
        }

        $filePath = __DIR__ . '/../tmp/' . implode('-', $packageNumbers) . '-full.pdf';

        file_put_contents($filePath, $raw);

        $this->assertFileExists($filePath);
    }

    /**
     * @test
     */
    public function testGeneratePdfQuarterSinglePackage()
    {
        $raw = $this->pplMyApi->getLabels([$this->package], LabelDecomposition::QUARTER);

        $this->assertNotEmpty($raw);

        $filePath = __DIR__ . '/../tmp/' . $this->package->getPackageNumber() . '-quarter.pdf';

        file_put_contents($filePath, $raw);

        $this->assertFileExists($filePath);
    }

    /**
     * @test
     */
    public function testGeneratePdfQuarterMultiplePackages()
    {
        $raw = $this->pplMyApi->getLabels($this->packages, LabelDecomposition::QUARTER);

        $this->assertNotEmpty($raw);

        $packageNumbers = [];

        /** @var Package $package */
        foreach ($this->packages AS $package) {
            $packageNumbers[] = $package->getPackageNumber();
        }

        $filePath = __DIR__ . '/../tmp/' . implode('-', $packageNumbers) . '-quarter.pdf';

        file_put_contents($filePath, $raw);

        $this->assertFileExists($filePath);
    }
}