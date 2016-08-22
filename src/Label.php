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
use Salamek\PplMyApi\Model\Package;

class Label
{
    /**
     * @param array $packages
     * @param int $decomposition
     * @return string
     * @throws \Exception
     */
    public static function generateLabels(array $packages, $decomposition = LabelDecomposition::FULL)
    {
        if (!in_array($decomposition, LabelDecomposition::$list)) {
            throw new WrongDataException(sprintf('unknown $decomposition ony %s are allowed', implode(', ', LabelDecomposition::$list)));
        }

        $packageNumbers = [];

        /** @var Package $package */
        foreach ($packages AS $package) {
            $packageNumbers[] = $package->getPackageNumber();
        }

        $pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Adam Schubert');
        $pdf->SetTitle(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
        $pdf->SetSubject(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
        $pdf->SetKeywords('Professional Parcel Logistic');
        $pdf->SetFont('freeserif');
        $pdf->setFontSubsetting(true);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);


        $quarterPosition = LabelPosition::TOP_LEFT;
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

                    $pdf = self::generateLabelQuarter($pdf, $package, $quarterPosition);
                    $quarterPosition++;
                    break;
            }
        }

        return $pdf->Output(null, 'S');
    }

    /**
     * @param \TCPDF $pdf
     * @param Package $package
     * @return \TCPDF
     */
    public static function generateLabelFull(\TCPDF $pdf, Package $package)
    {
        $x = 17;
        $pdf->Image(__DIR__ . '/../assets/logo.png', $x, 10, 66, '', 'PNG');

        //Contact info
        $contactInfoY = 45;
        $pdf->SetFont($pdf->getFontFamily(), '', 20);
        $pdf->Text($x, $contactInfoY, 'Modrá linka: 844 775 775');
        $pdf->Text($x, $contactInfoY + 10, 'E-mail: info@ppl.cz');
        $pdf->Text($x, $contactInfoY + 20, 'https://www.ppl.cz');


        //Barcode
        $pdf->StartTransform();
        $x = 78; //65
        $y = 85; //110
        $pdf->Rotate(270, $x, $y);
        $pdf->write1DBarcode($package->getPackageNumber(), 'I25+', $x, $y, 80, 60, 0.3, ['stretch' => true]);

        // Stop Transformation
        $pdf->StopTransform();

        //Barcode number
        $pdf->StartTransform();

        $x = 90;
        $y = 84;
        $pdf->Rotate(270, $x, $y);
        $pdf->SetFont($pdf->getFontFamily(), '', 23);
        $pdf->Text($x, $y, $package->getPackageNumber());
        // Stop Transformation
        $pdf->StopTransform();

        // PackagePosition of PackageCount
        $pdf->SetFont($pdf->getFontFamily(), 'B', 27);
        $pdf->MultiCell(40, 0, sprintf('%s/%s', $package->getPackagePosition(), $package->getPackageCount()), ['LTRB' => ['width' => 1]], 'C', 0, 0, 244, 175, true, 0, false, true, 0);

        // Dobirka
        if (in_array($package->getPackageProductType(), Product::$cashOnDelivery)) {
            $pdf->SetFont($pdf->getFontFamily(), 'B', 27);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->MultiCell(30, 0, 'DOB.:', ['LTRB' => ['width' => 0.7]], 'L', true, 0, 19, 175, true, 0, false, true, 0);
            $pdf->MultiCell(60, 0, sprintf('%s %s', $package->getPaymentInfo()->getCashOnDeliveryPrice(), $package->getPaymentInfo()->getCashOnDeliveryCurrency()), ['LTRB' => ['width' => 0.7]], 'R',
                true, 0, 45, 175, true, 0, false, true, 0);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(255, 255, 255);
        }


        //Prijemce
        $pdf->SetFont($pdf->getFontFamily(), '', 25);

        $pdf->Text(110, 9, 'Příjemce:');

        $x = 120;
        $y = 25;
        if ($package->getRecipient()->getName()) {
            $pdf->Text($x, $y, $package->getRecipient()->getName());
        }

        $pdf->Text($x, $y + 10, $package->getRecipient()->getContact());
        $pdf->Text($x, $y + 20, $package->getRecipient()->getStreet());
        $pdf->Text($x, $y + 30, sprintf('%s, %s', $package->getRecipient()->getCity(), $package->getRecipient()->getCountry()));

        $pdf->SetFont($pdf->getFontFamily(), 'B', 55);
        $pdf->Text($x, $y + 40, $package->getRecipient()->getZipCode());

        $pdf->SetFont($pdf->getFontFamily(), '', 25);
        $pdf->Text($x, $y + 63, sprintf('Tel.: %s', $package->getRecipient()->getPhone()));

        $pdf->MultiCell(173, 80, '', ['LTRB' => ['width' => 1]], 'L', 0, 0, 112, 21, true, 0, false, true, 0);
        $pdf->SetFont($pdf->getFontFamily(), 'B', 60);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->MultiCell(60, 15, (in_array(PackageService::EVENING_DELIVERY, self::packageServicesToArray($package)) ? 'Večer' : 'Den'), ['LTRB' => ['width' => 1]], 'C', true, 0, 224, 73, true, 0,
            false, true, 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        //Sender
        $pdf->SetFont($pdf->getFontFamily(), '', 25);
        $pdf->Text(112, 105, 'Odesílatel:');

        $x = 120;
        $y = 120;
        $pdf->Text($x, $y, $package->getSender()->getName());

        $pdf->Text($x, $y + 10, $package->getSender()->getName2());

        $pdf->Text($x, $y + 20, $package->getSender()->getStreet());

        $pdf->Text($x, $y + 30, sprintf('%s %s %s', $package->getSender()->getZipCode(), $package->getSender()->getCity(), $package->getSender()->getCountry()));

        $pdf->MultiCell(173, 48, '', ['LTRB' => ['width' => 1]], 'L', 0, 0, 112, 117, true, 0, false, true, 0);

        return $pdf;
    }

    /**
     * @param \TCPDF $pdf
     * @param Package $package
     * @param int $position
     * @return \TCPDF
     * @throws \Exception
     */
    public static function generateLabelQuarter(\TCPDF $pdf, Package $package, $position = LabelPosition::TOP_LEFT)
    {
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
                $yPositionOffset = 98;
                break;

            case LabelPosition::BOTTOM_RIGHT:
                $xPositionOffset = 150;
                $yPositionOffset = 98;
                break;
        }

        //Logo
        $pdf->Image(__DIR__ . '/../assets/logo.png', 3 + $xPositionOffset, 3 + $yPositionOffset, 34, '', 'PNG');

        //Contact info
        $pdf->SetFont($pdf->getFontFamily(), '', 9);
        $pdf->Text(3 + $xPositionOffset, 20 + $yPositionOffset, 'Modrá linka: 844 775 775');
        $pdf->Text(3 + $xPositionOffset, 25 + $yPositionOffset, 'E-mail: info@ppl.cz');
        $pdf->Text(3 + $xPositionOffset, 30 + $yPositionOffset, 'https://www.ppl.cz');


        //Barcode
        $pdf->StartTransform();
        $x = 34 + $xPositionOffset;
        $y = 40 + $yPositionOffset;
        $pdf->Rotate(270, $x, $y);
        $pdf->write1DBarcode($package->getPackageNumber(), 'I25+', $x, $y, 40, 30, 0.3, ['stretch' => true]);

        // Stop Transformation
        $pdf->StopTransform();

        //Barcode number
        $pdf->StartTransform();

        $x = 40 + $xPositionOffset;
        $y = 39 + $yPositionOffset;
        $pdf->Rotate(270, $x, $y);
        $pdf->SetFont($pdf->getFontFamily(), '', 13);
        $pdf->Text($x, $y, $package->getPackageNumber());
        // Stop Transformation
        $pdf->StopTransform();

        // PackagePosition of PackageCount
        $pdf->SetFont($pdf->getFontFamily(), 'B', 13);
        $pdf->MultiCell(20, 0, sprintf('%s/%s', $package->getPackagePosition(), $package->getPackageCount()), ['LTRB' => ['width' => 0.7]], 'C', 0, 0, 116 + $xPositionOffset, 85 + $yPositionOffset,
            true, 0, false, true, 0);

        // Dobirka
        if (in_array($package->getPackageProductType(), Product::$cashOnDelivery)) {
            $pdf->SetFont($pdf->getFontFamily(), 'B', 13);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->MultiCell(15, 0, 'DOB.:', ['LTRB' => ['width' => 0.7]], 'L', true, 0, 4 + $xPositionOffset, 85 + $yPositionOffset, true, 0, false, true, 0);
            $pdf->MultiCell(28, 0, sprintf('%s %s', $package->getPaymentInfo()->getCashOnDeliveryPrice(), $package->getPaymentInfo()->getCashOnDeliveryCurrency()), ['LTRB' => ['width' => 0.7]], 'R',
                true, 0, 19 + $xPositionOffset, 85 + $yPositionOffset, true, 0, false, true, 0);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFillColor(255, 255, 255);
        }

        //Prijemce
        $pdf->SetFont($pdf->getFontFamily(), '', 12);
        $pdf->Text(50 + $xPositionOffset, 3 + $yPositionOffset, 'Příjemce:');

        $x = 53 + $xPositionOffset;
        $y = 10 + $yPositionOffset;
        if ($package->getRecipient()->getName()) {
            $pdf->Text($x, $y, $package->getRecipient()->getName());
        }

        $pdf->Text($x, $y + 5, $package->getRecipient()->getContact());
        $pdf->Text($x, $y + 10, $package->getRecipient()->getStreet());
        $pdf->Text($x, $y + 15, sprintf('%s, %s', $package->getRecipient()->getCity(), $package->getRecipient()->getCountry()));

        $pdf->SetFont($pdf->getFontFamily(), 'B', 27);
        $pdf->Text($x, $y + 20, $package->getRecipient()->getZipCode());

        $pdf->SetFont($pdf->getFontFamily(), '', 10);
        $pdf->Text($x, $y + 33, sprintf('Tel.: %s', $package->getRecipient()->getPhone()));

        $pdf->MultiCell(85, 40, '', ['LTRB' => ['width' => 0.7]], 'L', 0, 0, 51 + $xPositionOffset, 9 + $yPositionOffset, true, 0, false, true, 0);
        $pdf->SetFont($pdf->getFontFamily(), 'B', 30);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(0, 0, 0);
        $pdf->MultiCell(30, 15, (in_array(PackageService::EVENING_DELIVERY, self::packageServicesToArray($package)) ? 'Večer' : 'Den'), ['LTRB' => ['width' => 0.7]], 'C', true, 0,
            106 + $xPositionOffset, 34 + $yPositionOffset, true, 0, false, true, 0);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        //Sender
        $pdf->SetFont($pdf->getFontFamily(), '', 12);
        $pdf->Text(50 + $xPositionOffset, 51 + $yPositionOffset, 'Odesílatel:');

        $x = 53 + $xPositionOffset;
        $y = 58 + $yPositionOffset;
        $pdf->SetFont($pdf->getFontFamily(), '', 10);
        $pdf->Text($x, $y, $package->getSender()->getName());

        $pdf->SetFont($pdf->getFontFamily(), '', 10);
        $pdf->Text($x, $y + 5, $package->getSender()->getName2());

        $pdf->SetFont($pdf->getFontFamily(), '', 10);
        $pdf->Text($x, $y + 10, $package->getSender()->getStreet());

        $pdf->SetFont($pdf->getFontFamily(), '', 10);
        $pdf->Text($x, $y + 15, sprintf('%s %s %s', $package->getSender()->getZipCode(), $package->getSender()->getCity(), $package->getSender()->getCountry()));

        $pdf->SetFont($pdf->getFontFamily(), 'B', 13);
        $pdf->MultiCell(85, 23, '', ['LTRB' => ['width' => 0.7]], 'L', 0, 0, 51 + $xPositionOffset, 57 + $yPositionOffset, true, 0, false, true, 0);

        return $pdf;
    }

    /**
     * @param Package $package
     * @return array
     */
    private static function packageServicesToArray(Package $package)
    {
        $return = [];
        foreach ($package->getPackageServices() AS $packageService) {
            $return[] = $packageService->getSvcCode();
        }

        return $return;
    }
}