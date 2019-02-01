<?php

namespace App\DocumentGenerator\Generator;


use Doctrine\ORM\EntityManagerInterface;
use FPDF;

class PDFDocumentGenerator
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $templateDir;

    /** @var string */
    private $sourceDir;

    /**
     * DocDocumentGenerator constructor.
     * @param EntityManagerInterface $em
     * @param string $templateDir
     * @param string $sourceDir
     */
    public function __construct(EntityManagerInterface $em, $templateDir, $sourceDir)
    {
        $this->em = $em;
        $this->templateDir = $templateDir;
        $this->sourceDir = $sourceDir;
    }

    public function generate(array $ids)
    {
        $files = [];

        foreach ($ids as $id)
        {
            $files[] = $this->generateSingle($id);
        }

        return $files;
    }

    private function generateSingle($id)
    {
        $chars = str_split(strtoupper("test"));

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image($this->templateDir . '/../src/PDF/' . 'template_pdf_1.jpg', 0, 0, 210);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(24);

        foreach ($chars as $index => $char){
            $pdf->Cell(1,80,$char);
            $pdf->Cell(3.41,80);
        }

        $pdf->AddPage();
        $pdf->Image($this->templateDir . '/../src/PDF/' . 'template_pdf_2.jpg', 0, 0, 210);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(24);

        foreach ($chars as $index => $char){
            $pdf->Cell(1,80,$char);
            $pdf->Cell(3.41,80);
        }

        $pdf->Output("file.pdf", 'D');

        return "file.pdf";
    }
}