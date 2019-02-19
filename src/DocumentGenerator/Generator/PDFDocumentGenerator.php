<?php

namespace App\DocumentGenerator\Generator;

use App\Entity\DocumentRequest;
use DateTime;
use tFPDF\PDF;

//https://github.com/DocnetUK/tfpdf/blob/master/tests/PDFGeneratedTest.php
class PDFDocumentGenerator
{
    /** @var string */
    private $templateDir;

    /** @var string */
    private $sourceDir;

    /**
     * DocDocumentGenerator constructor.
     * @param string $templateDir
     * @param string $sourceDir
     */
    public function __construct($templateDir, $sourceDir)
    {
        $this->templateDir = $templateDir;
        $this->sourceDir = $sourceDir;
        $this->createFolder($sourceDir);
    }

    public function generate(DocumentRequest $doc)
    {
        $documentDetail = $doc->getDocumentDetail();
        $newFile = $this->sourceDir . $doc->getFio() . '_' . (new DateTime())->getTimestamp() . ".pdf";

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->Image($this->templateDir . 'template_pdf_1.jpg', 0, 0, 210);
        $fontName = 'DejaVuSansCondensed';
        $pdf->AddFont($fontName,'','DejaVuSansCondensed.ttf',true);
        $pdf->AddFont($fontName,'B','DejaVuSansCondensed-Bold.ttf',true);

        $pdf->SetFont($fontName,'',8);

        $pdf = $this->setFio($pdf, $doc->getFio());
        $pdf = $this->setCitizen($pdf, $doc->getCitizen());
        $pdf = $this->setDateBirthAndSex($pdf, $doc->getBirthDate(), $doc->isSex());
        $pdf = $this->setExistDocument($pdf, $doc->getType(), $doc->getSeries(), $doc->getNumber());
        $pdf = $this->setDistrict($pdf, $documentDetail->getDistrict());
        $pdf = $this->setStreet($pdf, $documentDetail->getStreet());
        $pdf = $this->setHouseAndApartment($pdf, $documentDetail->getHouse(), $documentDetail->getApartment());
        $pdf = $this->setRegisterToPage1($pdf, $doc->getRegisterTo());

        $pdf->AddPage();
        $pdf->Image($this->templateDir . 'template_pdf_2.jpg', 0, 0, 210);
        $pdf->SetFont($fontName,'',8);

        $pdf = $this->setRegisterToPage2($pdf, $doc->getRegisterTo());
        $pdf = $this->setBossFio($pdf, $documentDetail->getBossFio());

        $file = $pdf->output();

        file_put_contents($newFile, $file);

        return $newFile;
    }

    public function getSource()
    {
        return $this->sourceDir;
    }

    private function setFio(PDF $pdf, $fio)
    {
        $fio = preg_split("/[\s]+/", $fio);
        $line1 = "";
        $line2 = "";

        if(count($fio)){
            $line1 = mb_strtoupper(count($fio) > 1 ? $fio[0] . ' ' . $fio[1] : $fio[0]);
            $line2 = "";


            for ($i = 2; $i < count($fio); $i++){
                $line2 .= $fio[$i] . ' ';
            }

            $line2 = mb_strtoupper(trim($line2));
        }

        $pdf->Ln(191.5);
        $pdf->SetLeftMargin(34);

        $pdf = $this->setUTF8Text($pdf, $line1);

        $pdf->Ln(6.2);
        $pdf->SetLeftMargin(34);

        return $this->setUTF8Text($pdf, $line2);
    }

    private function setCitizen(PDF $pdf, $citizen)
    {
        $citizen = mb_strtoupper((string)$citizen);

        $pdf->Ln(6.2);
        $pdf->SetLeftMargin(38.5);

        return $this->setUTF8Text($pdf, $citizen);
    }

    private function setDateBirthAndSex(PDF $pdf, $dateBirth, $sex)
    {
        $day = "";
        $month = "";
        $year = "";

        if($dateBirth instanceof DateTime){
            $day = $dateBirth->format("d");
            $month = $dateBirth->format("m");
            $year = $dateBirth->format("Y");
        }

        $pdf->Ln(6.5);
        $pdf->SetLeftMargin(43);

        $pdf = $this->setUTF8Text($pdf, $day);

        $pdf->SetLeftMargin(61);

        $pdf = $this->setUTF8Text($pdf, $month);

        $pdf->SetLeftMargin(74);

        $pdf = $this->setUTF8Text($pdf, $year);

        $sex ? $pdf->SetLeftMargin(126.5) : $pdf->SetLeftMargin(149);
        //@@todo fixed a bug (without it not working margin in future)
        $pdf->SetLeftMargin(0);

        return $this->setUTF8Text($pdf, 'X');
    }

    private function setExistDocument(PDF $pdf, $type, $series, $number)
    {
        $type = mb_strtoupper((string)$type);
        $series = mb_strtoupper((string)$series);
        $number = mb_strtoupper((string)$number);

        $pdf->Ln(6.5);
        $pdf->SetLeftMargin(69.3);
        $pdf = $this->setUTF8Text($pdf, $type);

        $pdf->SetLeftMargin(126.3);
        $pdf = $this->setUTF8Text($pdf, $series);

        $pdf->SetLeftMargin(148.7);
        $pdf->SetLeftMargin(0);

        return $this->setUTF8Text($pdf, $number);

    }

    private function setDistrict(PDF $pdf, $district)
    {
        $district = mb_strtoupper((string)$district);

        $pdf->Ln(15.8);
        $pdf->SetLeftMargin(34);

        return $this->setUTF8Text($pdf, $district);
    }

    private function setStreet(PDF $pdf, $street)
    {
        $street = mb_strtoupper((string)$street);

        $pdf->Ln(12.8);
        $pdf->SetLeftMargin(34);

        return $this->setUTF8Text($pdf, $street);
    }

    private function setHouseAndApartment(PDF $pdf, $house, $apartment, $typeApartment = "квартира")
    {
        $house = mb_strtoupper((string)$house);
        //$typeApartment = mb_strtoupper((string)$typeApartment);
        $apartment = mb_strtoupper((string)$apartment);

        $pdf->Ln(6.5);
        $pdf->SetLeftMargin(16);
        $pdf = $this->setUTF8Text($pdf, $house, 1.5);

//        $pdf->SetLeftMargin(138.7);
//        $pdf = $this->setUTF8Text($pdf, $typeApartment, 1.5);

        $pdf->SetLeftMargin(166.7);
        $pdf->SetLeftMargin(0);

        return $this->setUTF8Text($pdf, $apartment);

    }

    private function setRegisterToPage1(PDF $pdf, $date)
    {
        $day = "";
        $month = "";
        $year = "";

        if($date instanceof DateTime) {
            $day = $date->format("d");
            $month = $date->format("m");
            $year = $date->format("Y");
        }

        $pdf->Ln(12.5);
        $pdf->SetLeftMargin(56.2);

        $pdf = $this->setUTF8Text($pdf, $day);

        $pdf->SetLeftMargin(74.2);

        $pdf = $this->setUTF8Text($pdf, $month);

        $pdf->SetLeftMargin(87.2);
        $pdf->SetLeftMargin(0);

        return $this->setUTF8Text($pdf, $year);
    }

    private function setRegisterToPage2(PDF $pdf, $date)
    {
        $day = "";
        $month = "";
        $year = "";

        if($date instanceof DateTime) {
            $day = $date->format("d");
            $month = $date->format("m");
            $year = $date->format("Y");
        }

        $pdf->Ln(193.7);
        $pdf->SetLeftMargin(139.7);

        $pdf = $this->setUTF8Text($pdf, $day);

        $pdf->SetLeftMargin(157.7);

        $pdf = $this->setUTF8Text($pdf, $month);

        $pdf->SetLeftMargin(170.7);
        $pdf->SetLeftMargin(0);

        return $this->setUTF8Text($pdf, $year);
    }

    private function setBossFio(PDF $pdf, $fio)
    {
        $fio = preg_split("/[\s]+/", $fio);

        $line1 = "";
        $line2 = "";

        if(count($fio)){
            $line1 = mb_strtoupper(count($fio) > 1 ? $fio[0] . ' ' . $fio[1] : $fio[0]);
            $line2 = "";


            for ($i = 2; $i < count($fio); $i++){
                $line2 .= $fio[$i] . ' ';
            }

            $line2 = mb_strtoupper(trim($line2));
        }

        $pdf->Ln(6.5);
        $pdf->SetLeftMargin(34);

        $pdf = $this->setUTF8Text($pdf, $line1);

        $pdf->Ln(6.2);
        $pdf->SetLeftMargin(34);

        return $this->setUTF8Text($pdf, $line2);
    }

    private function setUTF8Text(PDF $pdf, $text, $widthBetweenChars = 3.41)
    {
        foreach ($this->mb_str_split($text) as $index => $char){
            $pdf->Cell(1,0, $char);
            $pdf->Cell($widthBetweenChars,0);
        }

        return $pdf;
    }

    private function mb_str_split( $string ) {
        # Split at all position not after the start: ^
        # and not before the end: $
        return preg_split('/(?<!^)(?!$)/u', $string );
    }

    private function createFolder($folder)
    {
        $folder = rtrim($folder, '/');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}