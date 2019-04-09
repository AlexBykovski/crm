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

        $birthDate = $doc->getBirthDate() ? $doc->getBirthDate()->format("d.m.Y") : "";

        $dayFrom = $doc->getRegisterFrom() ? $doc->getRegisterFrom()->format("d") : "";
        $monthFrom = $doc->getRegisterFrom() ? $doc->getRegisterFrom()->format("m") : "";
        $yearFrom = $doc->getRegisterFrom() ? $doc->getRegisterFrom()->format("Y") : "";

        $dayTo = $doc->getRegisterTo() ? $doc->getRegisterTo()->format("d") : "";
        $monthTo = $doc->getRegisterTo() ? $doc->getRegisterTo()->format("m") : "";
        $yearTo = $doc->getRegisterTo() ? $doc->getRegisterTo()->format("Y") : "";

        $dayIssued = $doc->getIssuedDate() ? $doc->getIssuedDate()->format("d") : "";
        $monthIssued = $doc->getIssuedDate() ? $doc->getIssuedDate()->format("m") : "";
        $yearIssued = $doc->getIssuedDate() ? $doc->getIssuedDate()->format("Y") : "";

        $templateProcessor = new TemplateProcessor($this->templateDir . 'template1.docx');
        $templateProcessor->setValue('rN', rand(1000, 9999));
        $templateProcessor->setValue('fio', $doc->getFio());
        $templateProcessor->setValue('dateBirth', $birthDate);
        $templateProcessor->setValue('placeBirth', $doc->getBirthPlace());
        $templateProcessor->setValue('dFrom', $dayFrom);
        $templateProcessor->setValue('dF', $dayFrom);
        $templateProcessor->setValue('dayFrom', $dayFrom);
        $templateProcessor->setValue('monthFrom', $monthFrom);
        $templateProcessor->setValue('mFrom', $monthFrom);
        $templateProcessor->setValue('mF', $monthFrom);
        $templateProcessor->setValue('yFrom', $yearFrom);
        $templateProcessor->setValue('yF', $yearFrom);
        $templateProcessor->setValue('dayTo', $dayTo);
        $templateProcessor->setValue('mTo', $monthTo);
        $templateProcessor->setValue('yTo', $yearTo);
        $templateProcessor->setValue('docType', $doc->getType());
        $templateProcessor->setValue('series', $doc->getSeries());
        $templateProcessor->setValue('number', $doc->getNumber());
        $templateProcessor->setValue('dI', $dayIssued);
        $templateProcessor->setValue('dayIssued', $dayIssued);
        $templateProcessor->setValue('monthIssued', $monthIssued);
        $templateProcessor->setValue('mI', $monthIssued);
        $templateProcessor->setValue('yearIssued', $yearIssued);
        $templateProcessor->setValue('yI', $yearIssued);
        $templateProcessor->setValue('issuedAuthority', $doc->getIssuedAuthority());
        $templateProcessor->setValue('department', $doc->getDocumentDetail()->getDepartment());
        $templateProcessor->setValue('bossFio', $doc->getDocumentDetail()->getBossFio());
        $templateProcessor->setValue('district', $doc->getDocumentDetail()->getDistrict());
        $templateProcessor->setValue('street', $doc->getDocumentDetail()->getStreet());
        $templateProcessor->setValue('house', $doc->getDocumentDetail()->getHouse());
        $templateProcessor->setValue('apartment', $doc->getDocumentDetail()->getApartment());
        $templateProcessor->saveAs($newFile);

        return $newFile;
    }

    public function getSource()
    {
        return $this->sourceDir;
    }

    private function createFolder($folder)
    {
        $folder = rtrim($folder, '/');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }
}