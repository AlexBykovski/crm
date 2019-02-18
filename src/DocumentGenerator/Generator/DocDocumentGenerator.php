<?php

namespace App\DocumentGenerator\Generator;

use App\Entity\DocumentRequest;
use DateTime;
use PhpOffice\PhpWord\TemplateProcessor;

class DocDocumentGenerator
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
        $newFile = $this->sourceDir . $doc->getFio() . '_' . (new DateTime())->getTimestamp() . ".docx";
        //${randomNumber}
        //${fio}
        //${dateBirth}
        //${placeBirth}
        //${dayFrom}
        //${monthFrom}
        //${yearFrom}
        //${dayTo}
        //${monthTo}
        //${yearTo}
        //${docType}
        //${series}
        //${number}
        //${dayIssued}
        //${monthIssued}
        //${yearIssued}
        //${issuedAuthority}
        //${department}
        //${bossFio}

        $templateProcessor = new TemplateProcessor($this->templateDir . 'template.docx');
        $templateProcessor->setValue('date', date("d-m-Y"));
        $templateProcessor->setValue('name', 'John Doe');
        $templateProcessor->saveAs($newFile);

        return $newFile;
    }

    public function getSource()
    {
        return $this->sourceDir;
    }

    private function createFolder($folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}