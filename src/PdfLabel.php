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
  /**
   * @param IPackage[] $packages
   *
   * @return string
   * @throws \Exception
   */
  public static function generateLabels(array $packages)
  {
    $packageNumbers = [];

    foreach ($packages as $package) {
      $packageNumbers[] = $package->getPackageNumber();
    }

    $pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Adam Schubert');
    $pdf->SetTitle(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
    $pdf->SetSubject(sprintf('Professional Parcel Logistic Label %s', implode(', ', $packageNumbers)));
    $pdf->SetKeywords('Professional Parcel Logistic');
    $pdf->SetFont('helvetica');
    $pdf->setFontSubsetting(true);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    /** @var Package $package */
    foreach ($packages as $package) {
      $pdf->AddPage();
      $pdf = self::generateLabel($pdf, $package);
      break;
    }

    return $pdf->Output(null, 'S');
  }

  /**
   * @param \TCPDF $pdf
   * @param IPackage $package
   *
   * @return \TCPDF
   */
  public static function generateLabel(\TCPDF $pdf, IPackage $package)
  {
    // Product Name
    $pdf->SetFont($pdf->getFontFamily(), '', 8);
    $pdf->Text(60, 3, 'PPL Parcel CZ Private');

    // Logo
    $pdf->Image(__DIR__ . '/../assets/logo.png', 115, 2, 29, '', 'PNG');

    // Barcode
    $pdf->StartTransform();
    $x = 28;
    $y = 96;
    $pdf->Rotate(90, $x, $y);
    $pdf->write1DBarcode($package->getPackageNumber(), 'C128B', $x, $y, 85, 28, 0.3, ['stretch' => true]);
    $pdf->StopTransform();

    // Barcode number
    $pdf->StartTransform();
    $x = 57;
    $y = 65;
    $pdf->Rotate(90, $x, $y);
    $pdf->SetFont($pdf->getFontFamily(), '', 7);
    $pdf->Text($x, $y, $package->getPackageNumber());
    $pdf->StopTransform();

    // RouteCode
    $pdf->StartTransform();
    $x = 6;
    $y = 40;
    $pdf->Rotate(90, $x, $y);
    $pdf->SetFont($pdf->getFontFamily(), '', 28);
    $pdf->Text($x, $y, '');
    $pdf->StopTransform();

    // ZipCode
    $pdf->StartTransform();
    $x = 7;
    $y = 72;
    $pdf->Rotate(90, $x, $y);
    $pdf->SetFont($pdf->getFontFamily(), '', 20);
    $pdf->Text($x, $y, $package->getRecipient()->getZipCode());
    $pdf->StopTransform();

    // DepoCode
    $pdf->StartTransform();
    $x = 6;
    $y = 98;
    $pdf->Rotate(90, $x, $y);
    $pdf->SetFont($pdf->getFontFamily(), '', 46);
    $pdf->Text($x, $y, $package->getDepoCode());
    $pdf->StopTransform();

    // Weight
    $pdf->StartTransform();
    $x = 15;
    $y = 52;
    $pdf->Rotate(90, $x, $y);
    $pdf->SetFont($pdf->getFontFamily(), '', 9);
    $pdf->Text($x, $y, $package->getWeight());
    $pdf->StopTransform();

    // Recipient
    $pdf->SetFont($pdf->getFontFamily(), '', 6);
    $pdf->Text(60, 7, 'Recipient / Príjemce:');
    $pdf->Text(90, 7, 'https://www.ppl.cz');
    $pdf->MultiCell(83, 42, '', ['LTRB' => ['width' => 0.5]], 'L', false, 0, 61, 10);
    $pdf->SetFont($pdf->getFontFamily(), '', 12);
    $pdf->Text(63, 12, 'Private');
    $pdf->Text(63, 18, $package->getRecipient()->getName());
    $pdf->Text(63, 24, $package->getRecipient()->getStreet());
    $pdf->Text(63, 30, $package->getRecipient()->getCity());
    $pdf->SetFont($pdf->getFontFamily(), 'b', 20);
    $pdf->Text(63, 36, $package->getRecipient()->getZipCode());
    $pdf->SetFont($pdf->getFontFamily(), '', 7);
    $pdf->Text(63, 47, 'Tel.: ' . $package->getRecipient()->getPhone());

    // Sender
    $pdf->SetFont($pdf->getFontFamily(), '', 6);
    $pdf->Text(60, 53, 'Sender / Odesílatel:');
    $pdf->Text(102, 53, 'Date printed / Datum vytišteni: ' . date('d-m-Y'));
    $pdf->MultiCell(83, 28, '', ['LTRB' => ['width' => 0.5]], 'L', false, 0, 61, 57);
    $pdf->SetFont($pdf->getFontFamily(), '', 12);
    $pdf->Text(63, 59, $package->getSender()->getName());
    $pdf->Text(63, 65, $package->getSender()->getContact());
    $pdf->Text(63, 71, $package->getSender()->getStreet());
    $pdf->Text(63, 77, $package->getSender()->getCity() . ' ' . $package->getSender()->getZipCode());

    // CheckSum
    $packageNumber = str_split($package->getPackageNumber());
    $packageNumberKeyOdd = array_filter(array_keys($packageNumber), function ($var) { return !($var & 1); });
    $packageNumberKeyEven = array_filter(array_keys($packageNumber), function ($var) { return ($var & 1); });

    $checkSum = 0;
    foreach ($packageNumberKeyOdd as $key) {
      $checkSum = $checkSum + $packageNumber[$key];
    }
    $checkSum = $checkSum * 3;
    foreach ($packageNumberKeyEven as $key) {
      $checkSum = $checkSum + $packageNumber[$key];
    }

    $pdf->write1DBarcode($checkSum, 'I25', 110, 75, 32, 9, 0.3, ['stretch' => true]);

    // PackNumber
    $pdf->SetFont($pdf->getFontFamily(), 'b', 12);
    $pdf->Text(116, 85, $package->getPackageNumber());
    $pdf->MultiCell(20, 9, '', ['LTRB' => ['width' => 0.5]], 'L', false, 0, 124, 91);
    $pdf->SetFont($pdf->getFontFamily(), '', 20);
    $pdf->Text(127, 91, $package->getPackagePosition() . '/' . $package->getPackageCount());

    return $pdf;
  }
}