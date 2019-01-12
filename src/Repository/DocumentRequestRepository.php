<?php

namespace App\Repository;

use App\Entity\DocumentRequest;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityRepository;

class DocumentRequestRepository extends EntityRepository
{
    /**
     * @return array
     * @throws \Exception
     */
    public function searchInitForManager()
    {
        $dayStart = new DateTime();
        $dayStart->sub(new DateInterval('P5D'));

        return $this->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.status = :status")
            ->andWhere("dr.createdAt >= :dateStart")
            ->setParameter("status", DocumentRequest::STATUS_NOT_HANDLED)
            ->setParameter("dateStart", $dayStart)
            ->orderBy("dr.createdAt", "ASC")
            ->getQuery()
            ->getResult();
    }
}