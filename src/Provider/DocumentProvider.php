<?php

namespace App\Provider;

use App\Entity\DocumentRequest;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class DocumentProvider
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * DocumentProvider constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function provide(FormInterface $form, User $user)
    {
        if($form->isSubmitted()){
            $dateFrom = $form->get("dateFrom")->getData() instanceof DateTime ? $form->get("dateFrom")->getData() : null;
            $dateTo = $form->get("dateTo")->getData() instanceof DateTime ? $form->get("dateTo")->getData() : null;
            $text = $form->get("text")->getData() ?: null;

            if(!$dateFrom && !$dateTo && !$text){
                $documentRequests = $this->em->getRepository(DocumentRequest::class)->searchInit($user);
            }
            else{
                $documentRequests = $this->em->getRepository(DocumentRequest::class)->searchByParams($user, $dateFrom, $dateTo, $text);
            }
        }
        else{
            $documentRequests = $this->em->getRepository(DocumentRequest::class)->searchInit($user);
        }

        return $this->parseDocumentRequests($documentRequests);

    }

    private function parseDocumentRequests(array $docRequests)
    {
        $parsedDocRequests = [];

        /** @var DocumentRequest $docRequest */
        foreach ($docRequests as $docRequest){
            $date = $docRequest->getCreatedAt()->format("d.m.Y");

            if(!array_key_exists($date, $parsedDocRequests)){
                $parsedDocRequests[$date] = [];
            }

            $parsedDocRequests[$date][] = $docRequest;
        }

        krsort($parsedDocRequests);

        return $parsedDocRequests;
    }
}