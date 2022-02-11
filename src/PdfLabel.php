<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi;


use Salamek\PplMyApi\Enum\LabelDecomposition;
use Salamek\PplMyApi\Enum\LabelPosition;
use Salamek\PplMyApi\Enum\PackageService;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Model\IPackage;
use Salamek\PplMyApi\Model\Package;

class PdfLabel implements ILabel
{

    /** @var */
    private static $fontFamily = 'dejavusans';

    /**
     * @param IPackage[] $packages
     * @param int $decomposition
     * @param int $quarterPosition
     * @return string
     * @throws \Exception
     */
    public static function generateLabels(array $packages, $decomposition = LabelDecomposition::FULL, $quarterPosition = LabelPosition::TOP_LEFT, \DateTime $printDate = null)
    {
        if (!in_array($decomposition, LabelDecomposition::$list)) {
            throw new WrongDataException(sprintf('unknown $decomposition only %s are allowed', implode(', ', LabelDecomposition::$list)));
        }

        if (!in_array($quarterPosition, LabelPosition::$list)) {
            throw new WrongDataException(sprintf('unknown $quarterPosition only %s are allowed', implode(', ', LabelPosition::$list)));
        }

        $packageNumbers = [];

        /** @var IPackage $package */
        foreach ($packages AS $package) {
            $packageNumbers[] = $package->getPackageNumber();
        }

        $pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Adam Schubert');
        $pdf->SetTitle(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
        $pdf->SetSubject(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
        $pdf->SetKeywords('Professional Parcel Logistic');
        $pdf->SetFont(self::$fontFamily);
        $pdf->setFontSubsetting(true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0, true);
        $pdf->SetAutoPageBreak(false, 0);

        /** @var Package $package */
        foreach ($packages AS $package) {
            switch ($decomposition) {
                case LabelDecomposition::FULL:
                    $pdf->AddPage();
                    $pdf = self::generateLabelFull($pdf, $package);
                    break;

                case LabelDecomposition::QUARTER:
                    if ($quarterPosition > LabelPosition::BOTTOM_RIGHT) {
                        $quarterPosition = LabelPosition::TOP_LEFT;
                    }

                    if ($quarterPosition == LabelPosition::TOP_LEFT) {
                        $pdf->AddPage();
                    }

                    $pdf = self::generateLabelQuarter($pdf, $package, $quarterPosition, $printDate);
                    $quarterPosition++;
                    break;
            }
        }

        return $pdf->Output(null, 'S');
    }

    /**
     * @param \TCPDF $pdf
     * @param IPackage $package
     * @return \TCPDF
     */
    public static function generateLabelFull(\TCPDF $pdf, IPackage $package, \DateTime $printDate = null)
    {
        if ($printDate === null) {
            $printDate = new \DateTime();
        }
        
        $scale = 2;

        //Logo
        $pdf->Image(__DIR__ . '/../vendor/salamek/ppl-my-api/assets/logo.png', 110*$scale, 3*$scale, 27*$scale, '', 'PNG');

        //Contact info
        $pdf->SetFont(self::$fontFamily, '', 6*$scale);
        $pdf->Text(58*$scale, 4*$scale, Product::$names[$package->getPackageProductType()]);
        $pdf->Text(85*$scale, 7.5*$scale, 'https://www.ppl.cz');

        //Recipient
        $pdf->SetFont(self::$fontFamily, '', 6*$scale);
        $pdf->Text(58*$scale, 7.5*$scale, 'Recipient / Příjemce');

        $pdf->SetFont(self::$fontFamily, 'B', 13*$scale);
        $x = 58.5*$scale;
        $y = 11*$scale;
        if ($package->getRecipient()->getName()) {
            $pdf->Text($x, $y, $package->getRecipient()->getName());
        }

        $pdf->Text($x, $y + (7*$scale), $package->getRecipient()->getContact());
        $pdf->Text($x, $y + (14*$scale), $package->getRecipient()->getStreet());
        $pdf->Text($x, $y + (21*$scale), sprintf('%s', $package->getRecipient()->getCity()));

        $pdf->SetFont(self::$fontFamily, 'B', 20*$scale);
        $pdf->Text($x, $y + (27*$scale), $package->getRecipient()->getZipCode());

        $pdf->SetFont(self::$fontFamily, '', 20*$scale);
        $pdf->MultiCell(15*$scale, 9*$scale, $package->getRecipient()->getCountry(), ['LTRB' => ['width' => 0.2]], 'C', 0, 0, 119.5*$scale, 45.3*$scale, true, 0, false, true, 0);

        $pdf->SetFont(self::$fontFamily, '', 7*$scale);
        $pdf->Text($x, $y + (35.7*$scale), $package->getRecipient()->getName2());
        $pdf->Text($x, $y + (39.5*$scale), sprintf('Tel.: %s', $package->getRecipient()->getPhone()));

        $pdf->MultiCell(76*$scale, 43.3*$scale, '', ['LTRB' => ['width' => 0.2]], 'L', 0, 0, 58.5*$scale, 11*$scale, true, 0, false, true, 0);

        //Sender
        $pdf->SetFont(self::$fontFamily, '', 6*$scale);
        $pdf->Text(58*$scale, 55.5*$scale, 'Sender / Odesílatel');
        $pdf->Text(99*$scale, 55.5*$scale, 'Datum tisku etikety: '.$printDate->format('d-m-Y'));

        $x = 58.5*$scale;
        $y = 59.5*$scale;
        $pdf->SetFont(self::$fontFamily, 'B', 10*$scale);

        $pdf->Text($x, $y, $package->getSender()->getName());
        $pdf->Text($x, $y + (4.5*$scale), $package->getSender()->getName2());
        $pdf->Text($x, $y + (9*$scale), $package->getSender()->getStreet());
        $pdf->Text($x, $y + (13.5*$scale), sprintf('%s %s', $package->getSender()->getCity(), $package->getSender()->getCountry()));
        $pdf->Text($x, $y + (18*$scale), $package->getSender()->getZipCode());

        $pdf->MultiCell(76*$scale, 27*$scale, '', ['LTRB' => ['width' => 0.2]], 'L', 0, 0, 58.5*$scale, 58.7*$scale, true, 0, false, true, 0);

        //Barcode
        $x = 99*$scale;
        $y = 76.2*$scale;
        $pdf->write1DBarcode($package->getPackageNumber(), 'I25+', $x, $y, 32*$scale, 9*$scale, 0.3*$scale, ['stretch' => true]);
        $pdf->SetFont(self::$fontFamily, 'B', 12*$scale);
        $pdf->Text($x-(2*$scale), $y+(11*$scale), $package->getPackageNumber());

        //Barcode-depocode
        $pdf->StartTransform();
        $x = 28*$scale;
        $y = 96*$scale;
        $pdf->Rotate(90, $x, $y);
        $pdf->write1DBarcode($package->getPackageNumber().'-'.$package->getCityRouting()->getRouteCode(), 'C128B', $x, $y, 85*$scale, 27*$scale, 0.3*$scale, ['stretch' => true]);
        $pdf->StopTransform();

        //Barcode-depocode text
        $pdf->StartTransform();
        $x = 55*$scale;
        $y = 72*$scale;
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, 'B', 7*$scale);
        $pdf->Text($x, $y, $package->getPackageNumber().'-'.$package->getCityRouting()->getRouteCode());
        $pdf->StopTransform();

        // Evening / Day delivery label should be added only for private packages
        if (in_array($package->getPackageProductType(), Product::$privateProducts)) {
            $x = 19.5*$scale;
            $y = 78*$scale;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, 'B', 20*$scale);
            $pdf->Text($x, $y, (in_array(PackageService::EVENING_DELIVERY, \Salamek\PplMyApi\Model\PackageService::packageServicesToArray($package)) ? 'VEČER' : 'DEN'));
            $pdf->StopTransform();
        }

        //Depo code
        $x = 10*$scale;
        $y = 98*$scale;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 37*$scale);
        $pdf->Text($x, $y, $package->getDepoCode());
        $pdf->StopTransform();

        //Route code
        $x = 9*$scale;
        $y = 40*$scale;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 25*$scale);
        $pdf->Text($x, $y, $package->getCityRouting()->getRouteCode());
        $pdf->StopTransform();

        //ZIP code
        $x = 9*$scale;
        $y = 70*$scale;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 17*$scale);
        $pdf->Text($x, $y, $package->getRecipient()->getZipCode());
        $pdf->StopTransform();

        //Country code
        if (in_array($package->getPackageProductType(), [Product::PPL_PARCEL_CONNECT, Product::PPL_PARCEL_CONNECT_COD])) {
            $x = 17.7*$scale;
            $y = 40*$scale;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, '', 25*$scale);
            $pdf->Text($x, $y, $package->getRecipient()->getCountry());
            $pdf->StopTransform();
        }

        //Weight
        if($package->getWeightedPackageInfo()){
            $x = 16*$scale;
            $y = 50*$scale;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, '', 8*$scale);
            $pdf->Text($x, $y, $package->getWeightedPackageInfo()->getWeight().' kg');
            $pdf->StopTransform();
        }

        //Note
        if(!empty($package->getNote())){
            $pdf->SetFont(self::$fontFamily, '', 7*$scale);
            $noteLines = explode('<br>', $package->getNote());
            if(isset($noteLines[0])){
                $pdf->Text(58*$scale, 87*$scale, 'Pozn.: '.$noteLines[0]);
            }
            if(isset($noteLines[1])){
                $pdf->Text(66.2*$scale, 90*$scale, $noteLines[1]);
            }
        }

        //COD
        if (in_array($package->getPackageProductType(), Product::$cashOnDelivery)) {
            $pdf->SetFont(self::$fontFamily, 'B', 12*$scale);
            $pdf->Text(58*$scale, 94*$scale, sprintf('COD/DOB: %s %s', $package->getPaymentInfo()->getCashOnDeliveryPrice(), $package->getPaymentInfo()->getCashOnDeliveryCurrency()));
        }

        // PackagePosition of PackageCount
        $pdf->SetFont(self::$fontFamily, '', 15*$scale);
        $pdf->MultiCell(15*$scale, 7*$scale, sprintf('%s/%s', $package->getPackagePosition(), $package->getPackageCount()), ['LTRB' => ['width' => 0.2]], 'C', 0, 0, 119.5*$scale, 94*$scale, true, 0, false, true, 0);

        return $pdf;
    }

    /**
     * @param \TCPDF $pdf
     * @param IPackage $package
     * @param int $position
     * @return \TCPDF
     * @throws \Exception
     */
    public static function generateLabelQuarter(\TCPDF $pdf, IPackage $package, $position = LabelPosition::TOP_LEFT, \DateTime $printDate = null)
    {
        if ($printDate === null) {
            $printDate = new \DateTime();
        }
        
        if (!in_array($position, [1, 2, 3, 4])) {
            throw new \Exception('Unknow position');
        }

        switch ($position) {
            default:
            case LabelPosition::TOP_LEFT:
                $xPositionOffset = 0;
                $yPositionOffset = 0;
                break;

            case LabelPosition::TOP_RIGHT:
                $xPositionOffset = 150;
                $yPositionOffset = 0;
                break;

            case LabelPosition::BOTTOM_LEFT:
                $xPositionOffset = 0;
                $yPositionOffset = 104;
                break;

            case LabelPosition::BOTTOM_RIGHT:
                $xPositionOffset = 150;
                $yPositionOffset = 104;
                break;
        }

        //Logo
        $pdf->Image(__DIR__ . '/../vendor/salamek/ppl-my-api/assets/logo.png', 110 + $xPositionOffset, 3 + $yPositionOffset, 27, '', 'PNG');

        //Contact info
        $pdf->SetFont(self::$fontFamily, '', 6);
        $pdf->Text(58 + $xPositionOffset, 4 + $yPositionOffset, Product::$names[$package->getPackageProductType()]);
        $pdf->Text(85 + $xPositionOffset, 7.5 + $yPositionOffset, 'https://www.ppl.cz');

        //Recipient
        $pdf->SetFont(self::$fontFamily, '', 6);
        $pdf->Text(58 + $xPositionOffset, 7.5 + $yPositionOffset, 'Recipient / Příjemce');

        $pdf->SetFont(self::$fontFamily, 'B', 13);
        $x = 58.5 + $xPositionOffset;
        $y = 11 + $yPositionOffset;
        if ($package->getRecipient()->getName()) {
            $pdf->Text($x, $y, $package->getRecipient()->getName());
        }

        $pdf->Text($x, $y + 7, $package->getRecipient()->getContact());
        $pdf->Text($x, $y + 14, $package->getRecipient()->getStreet());
        $pdf->Text($x, $y + 21, sprintf('%s', $package->getRecipient()->getCity()));

        $pdf->SetFont(self::$fontFamily, 'B', 20);
        $pdf->Text($x, $y + 27, $package->getRecipient()->getZipCode());

        $pdf->SetFont(self::$fontFamily, '', 20);
        $pdf->MultiCell(15, 9, $package->getRecipient()->getCountry(), ['LTRB' => ['width' => 0.2]], 'C', 0, 0, 119.5 + $xPositionOffset, 45.3 + $yPositionOffset, true, 0, false, true, 0);

        $pdf->SetFont(self::$fontFamily, '', 7);
        $pdf->Text($x, $y + 35.7, $package->getRecipient()->getName2());
        $pdf->Text($x, $y + 39.5, sprintf('Tel.: %s', $package->getRecipient()->getPhone()));

        $pdf->MultiCell(76, 43.3, '', ['LTRB' => ['width' => 0.2]], 'L', 0, 0, 58.5 + $xPositionOffset, 11 + $yPositionOffset, true, 0, false, true, 0);

        //Sender
        $pdf->SetFont(self::$fontFamily, '', 6);
        $pdf->Text(58 + $xPositionOffset, 55.5 + $yPositionOffset, 'Sender / Odesílatel');
        $pdf->Text(99 + $xPositionOffset, 55.5 + $yPositionOffset, 'Datum tisku etikety: '.$printDate->format('d-m-Y'));

        $x = 58.5 + $xPositionOffset;
        $y = 59.5 + $yPositionOffset;
        $pdf->SetFont(self::$fontFamily, 'B', 10);

        $pdf->Text($x, $y, $package->getSender()->getName());
        $pdf->Text($x, $y + 4.5, $package->getSender()->getName2());
        $pdf->Text($x, $y + 9, $package->getSender()->getStreet());
        $pdf->Text($x, $y + 13.5, sprintf('%s %s', $package->getSender()->getCity(), $package->getSender()->getCountry()));
        $pdf->Text($x, $y + 18, $package->getSender()->getZipCode());

        $pdf->MultiCell(76, 27, '', ['LTRB' => ['width' => 0.2]], 'L', 0, 0, 58.5 + $xPositionOffset, 58.7 + $yPositionOffset, true, 0, false, true, 0);

        //Barcode
        $x = 99 + $xPositionOffset;
        $y = 76.2 + $yPositionOffset;
        $pdf->write1DBarcode($package->getPackageNumber(), 'I25+', $x, $y, 32, 9, 0.3, ['stretch' => true]);
        $pdf->SetFont(self::$fontFamily, 'B', 12);
        $pdf->Text($x-2, $y+11, $package->getPackageNumber());

        //Barcode-depocode
        $pdf->StartTransform();
        $x = 28 + $xPositionOffset;
        $y = 96 + $yPositionOffset;
        $pdf->Rotate(90, $x, $y);
        $pdf->write1DBarcode($package->getPackageNumber().'-'.$package->getCityRouting()->getRouteCode(), 'C128B', $x, $y, 85, 27, 0.3, ['stretch' => true]);
        $pdf->StopTransform();

        //Barcode-depocode text
        $pdf->StartTransform();
        $x = 55 + $xPositionOffset;
        $y = 72 + $yPositionOffset;
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, 'B', 7);
        $pdf->Text($x, $y, $package->getPackageNumber().'-'.$package->getCityRouting()->getRouteCode());
        $pdf->StopTransform();

        // Evening / Day delivery label should be added only for private packages
        if (in_array($package->getPackageProductType(), Product::$privateProducts)) {
            $x = 19.5 + $xPositionOffset;
            $y = 78 + $yPositionOffset;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, 'B', 20);
            $pdf->Text($x, $y, (in_array(PackageService::EVENING_DELIVERY, \Salamek\PplMyApi\Model\PackageService::packageServicesToArray($package)) ? 'VEČER' : 'DEN'));
            $pdf->StopTransform();
        }

        //Depo code
        $x = 10 + $xPositionOffset;
        $y = 98 + $yPositionOffset;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 37);
        $pdf->Text($x, $y, $package->getDepoCode());
        $pdf->StopTransform();

        //Route code
        $x = 9 + $xPositionOffset;
        $y = 40 + $yPositionOffset;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 25);
        $pdf->Text($x, $y, $package->getCityRouting()->getRouteCode());
        $pdf->StopTransform();

        //ZIP code
        $x = 9 + $xPositionOffset;
        $y = 70 + $yPositionOffset;
        $pdf->StartTransform();
        $pdf->Rotate(90, $x, $y);
        $pdf->SetFont(self::$fontFamily, '', 17);
        $pdf->Text($x, $y, $package->getRecipient()->getZipCode());
        $pdf->StopTransform();

        //Country code
        if (in_array($package->getPackageProductType(), [Product::PPL_PARCEL_CONNECT, Product::PPL_PARCEL_CONNECT_COD])) {
            $x = 17.7 + $xPositionOffset;
            $y = 40 + $yPositionOffset;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, '', 25);
            $pdf->Text($x, $y, $package->getRecipient()->getCountry());
            $pdf->StopTransform();
        }

        //Weight
        if($package->getWeightedPackageInfo()){
            $x = 16 + $xPositionOffset;
            $y = 50 + $yPositionOffset;
            $pdf->StartTransform();
            $pdf->Rotate(90, $x, $y);
            $pdf->SetFont(self::$fontFamily, '', 8);
            $pdf->Text($x, $y, $package->getWeightedPackageInfo()->getWeight().' kg');
            $pdf->StopTransform();
        }

        //Note
        if(!empty($package->getNote())){
            $pdf->SetFont(self::$fontFamily, '', 7);
            $noteLines = explode('<br>', $package->getNote());
            if(isset($noteLines[0])){
                $pdf->Text(58 + $xPositionOffset, 87 + $yPositionOffset, 'Pozn.: '.$noteLines[0]);
            }
            if(isset($noteLines[1])){
                $pdf->Text(66.2 + $xPositionOffset, 90 + $yPositionOffset, $noteLines[1]);
            }
        }

        //COD
        if (in_array($package->getPackageProductType(), Product::$cashOnDelivery)) {
            $pdf->SetFont(self::$fontFamily, 'B', 12);
            $pdf->Text(58 + $xPositionOffset, 94 + $yPositionOffset, sprintf('COD/DOB: %s %s', $package->getPaymentInfo()->getCashOnDeliveryPrice(), $package->getPaymentInfo()->getCashOnDeliveryCurrency()));
        }

        // PackagePosition of PackageCount
        $pdf->SetFont(self::$fontFamily, '', 15);
        $pdf->MultiCell(15, 7, sprintf('%s/%s', $package->getPackagePosition(), $package->getPackageCount()), ['LTRB' => ['width' => 0.2]], 'C', 0, 0, 119.5 + $xPositionOffset, 94 + $yPositionOffset, true, 0, false, true, 0);

        return $pdf;
    }
}
