<?php

namespace App\DocumentGenerator;

use App\DocumentGenerator\Generator\DocDocumentGenerator;
use App\DocumentGenerator\Generator\PDFDocumentGenerator;

class DocumentGeneratorFactory
{
    const RUSSIA = "Россия";

    /** @var DocDocumentGenerator */
    private $docGenerator;

    /** @var PDFDocumentGenerator */
    private $pdfGenerator;

    /**
     * DocumentGeneratorFactory constructor.
     *
     * @param DocDocumentGenerator $docGenerator
     * @param PDFDocumentGenerator $pdfGenerator
     */
    public function __construct(DocDocumentGenerator $docGenerator, PDFDocumentGenerator $pdfGenerator)
    {
        $this->docGenerator = $docGenerator;
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * @return  DocDocumentGenerator|PDFDocumentGenerator
     */
    public function factory($citizen)
    {
        switch ($citizen){
            case self::RUSSIA:
                return $this->docGenerator;
            default:
                return $this->pdfGenerator;
        }
    }

    public function getSourceFolder($citizen)
    {
        switch ($citizen){
            case self::RUSSIA:
                return $this->docGenerator->getSource();
            default:
                return $this->pdfGenerator->getSource();
        }
    }
}