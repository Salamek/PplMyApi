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
     * @param int $decomposition
     * @return string
     * @throws \Exception
     */
    public static function generateLabels(array $packages, $decomposition = LabelDecomposition::FULL);

    /**
     * @param \TCPDF $pdf
     * @param IPackage $package
     * @return \TCPDF
     */
    public static function generateLabelFull(\TCPDF $pdf, IPackage $package);

    /**
     * @param \TCPDF $pdf
     * @param IPackage $package
     * @param int $position
     * @return \TCPDF
     * @throws \Exception
     */
    public static function generateLabelQuarter(\TCPDF $pdf, IPackage $package, $position = LabelPosition::TOP_LEFT);

}