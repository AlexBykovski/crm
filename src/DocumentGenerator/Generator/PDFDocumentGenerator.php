<?php

namespace App\DocumentGenerator\Generator;

use App\Entity\DocumentRequest;
use DateTime;
use FPDF;

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
        $newFile = $this->sourceDir . $doc->getFio() . '_' . (new DateTime())->getTimestamp() . ".pdf";

        $chars = str_split(strtoupper("test"));

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($this->templateDir . 'template_pdf_1.jpg', 0, 0, 210);
        $pdf->SetFont('Arial','',8);

        $pdf = $this->setFio($pdf, $doc->getFio());

        $pdf->AddPage();
        $pdf->Image($this->templateDir . 'template_pdf_2.jpg', 0, 0, 210);
        $pdf->SetFont('Arial','',8);
        //$pdf->Cell(24);

//        foreach ($chars as $index => $char){
//            $pdf->Cell(1,80,$char);
//            $pdf->Cell(3.41,80);
//        }

        $pdf->Output($newFile, 'F');

        return $newFile;
    }

    public function getSource()
    {
        return $this->sourceDir;
    }

    private function setFio(FPDF $pdf, $fio)
    {
        $fio = preg_split("/[\s]+/", $fio);

        if(!count($fio)){
            return $pdf;
        }

        $line1 = strtoupper(count($fio) > 1 ? $fio[0] . ' ' . $fio[1] : $fio[0]);
        $line2 = "";

        $line1 = json_encode($line1, JSON_UNESCAPED_UNICODE);

        for ($i = 2; $i < count($fio); $i++){
            $line2 .= $fio[$i] . ' ';
        }

        $line2 = strtoupper(trim($line2));

        $pdf->Cell(24);

        foreach (str_split($line1) as $index => $char){
            $pdf->Cell(1,80, $char);
            $pdf->Cell(3.41,80);
        }

        return $pdf;
    }

    private function createFolder($folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}