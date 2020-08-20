<?php
/**
 * User: Martinus - Samuel Szabo
 * Date: 24.11.2017
 */

namespace Salamek\PplMyApi;


use Salamek\PplMyApi\Enum\LabelDecomposition;
use Salamek\PplMyApi\Enum\LabelPosition;
use Salamek\PplMyApi\Model\IPackage;

interface ILabel
{

    /**
     * @param IPackage[] $packages
     * @return string
     * @throws \Exception
     */
    public static function generateLabels(array $packages);

    /**
     * @param \TCPDF $pdf
     * @param IPackage $package
     * @return \TCPDF
     */
    public static function generateLabel(\TCPDF $pdf, IPackage $package);

}