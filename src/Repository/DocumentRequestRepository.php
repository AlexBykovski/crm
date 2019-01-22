<?php

namespace App\Repository;

use App\Entity\DocumentRequest;
use App\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityRepository;

class DocumentRequestRepository extends EntityRepository
{
    /**
     * @return array
     * @throws \Exception
     */
    public function search(User $user)
    {
        $dayStart = new DateTime();
        $dayStart->sub(new DateInterval('P5D'));

        return $this->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.status IN (:statuses)")
            ->andWhere("dr.createdAt >= :dateStart")
            ->setParameter("statuses", $user->getSearchStatuses())
            ->setParameter("dateStart", $dayStart)
            ->orderBy("dr.createdAt", "ASC")
            ->getQuery()
            ->getResult();
    }
}