<?php
/**
 * Created by PhpStorm.
 * User: aleksander
 * Date: 02.02.19
 * Time: 0:16
 */

namespace App\DocumentGenerator\Generator;


use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpWord\TemplateProcessor;

class DocDocumentGenerator
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
        $templateProcessor = new TemplateProcessor($this->rootDir . 'template.docx');
        $templateProcessor->setValue('date', date("d-m-Y"));
        $templateProcessor->setValue('name', 'John Doe');
        $templateProcessor->saveAs('MyWordFile.docx');

        return 'MyWordFile.docx';
    }
}