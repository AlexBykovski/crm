<?php

namespace App\DocumentGenerator;

use App\Entity\DocumentRequest;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use ZipArchive;

class DocumentsGenerator
{
    const RUSSIA = "Россия";

    /** @var DocumentGeneratorFactory */
    private $generatorFactory;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $source;

    /**
     * DocumentGeneratorFactory constructor.
     *
     * @param DocumentGeneratorFactory $generatorFactory
     * @param EntityManagerInterface $em
     * @param string $source
     */
    public function __construct(
        DocumentGeneratorFactory $generatorFactory,
        EntityManagerInterface $em,
        string $source
    )
    {
        $this->generatorFactory = $generatorFactory;
        $this->em = $em;
        $this->source = $source;

        $this->createFolder($source);
    }

    public function generateDocuments(array $ids)
    {
        if(!count($ids)){
            return false;
        }

        $archiveName = $this->getArchiveName($ids);

        if(!$archiveName){
            return false;
        }

        $zip = new ZipArchive();
        $zip->open($this->source . $archiveName, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        foreach ($ids as $id)
        {
            $doc = $this->em->getRepository(DocumentRequest::class)->find($id);

            if(!($doc instanceof DocumentRequest)){
                continue;
            }

            $generator = $this->generatorFactory->factory($doc->getCitizen());
            $filePath = $generator->generate($doc);
            $fileName = str_replace($this->generatorFactory->getSourceFolder($doc->getCitizen()), "", $filePath);

            $zip->addFile($filePath, $fileName);
        }

        $zip->close();

        return $this->source . $archiveName;
    }

    private function createFolder($folder)
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    private function getArchiveName(array $ids)
    {
        $doc = $this->em->getRepository(DocumentRequest::class)->find(array_values($ids)[0]);

        if(!($doc instanceof DocumentRequest)){
            return false;
        }

        if(count($ids) === 1){
            return $doc->getFio() . '_' . (new DateTime())->getTimestamp() . '.zip';
        }
        else{
            return $doc->getCreatedAt()->format("d_m_Y") . '_' . (new DateTime())->getTimestamp() . '.zip';
        }
    }
}