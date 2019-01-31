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
    public function searchInit(User $user)
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

    public function searchByParams(User $user, DateTime $dateFrom = null, DateTime $dateTo = null, $text = null)
    {
        $query = $this->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.status IN (:statuses)")
            ->setParameter("statuses", $user->getSearchStatuses());

        if($dateFrom){
            $query->andWhere("dr.createdAt >= :dateFrom")
                ->setParameter("dateFrom", $dateFrom);
        }

        if($dateTo){
            $query->andWhere("dr.createdAt <= :dateTo")
                ->setParameter("dateTo", $dateTo);
        }

        if($text){
            $query->andWhere("dr.fio LIKE :text")
                ->setParameter("text",  '%' . $text . '%');
        }

        return $query
            ->orderBy("dr.createdAt", "ASC")
            ->getQuery()
            ->getResult();
    }
}