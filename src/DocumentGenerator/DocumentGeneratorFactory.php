<?php

namespace App\DocumentGenerator;

use App\DocumentGenerator\Generator\DocDocumentGenerator;
use App\DocumentGenerator\Generator\PDFDocumentGenerator;

class DocumentGeneratorFactory
{
    const RUSSIA = "Российская Федерация";

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

    public function factory($citizen)
    {
        switch ($citizen){
            case self::RUSSIA:
                return $this->docGenerator;
            default:
                return $this->pdfGenerator;
        }
    }
}