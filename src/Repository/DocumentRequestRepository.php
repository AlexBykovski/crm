<?php

namespace App\Repository;

use App\Entity\DocumentRequest;
use App\Entity\Manager;
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
        $dayEnd = $user instanceof Manager ? $user->getWorkUpdatedAt() : new DateTime();
        $dayEnd->setTime(23,59,59);

        return $this->createQueryBuilder('dr')
            ->select('dr')
            ->where("dr.status IN (:statuses)")
            ->andWhere("dr.createdAt >= :dateStart")
            ->andWhere("dr.createdAt <= :dateEnd")
            ->setParameter("statuses", $user->getSearchStatuses())
            ->setParameter("dateStart", $dayStart)
            ->setParameter("dateEnd", $dayEnd)
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

    public function findCountBetweenDates(DateTime $startAt, DateTime $endAt, $statuses = [])
    {
        return $this->createQueryBuilder('dr')
            ->select('COUNT(dr) as count')
            ->where("dr.status IN (:statuses)")
            ->andWhere("dr.createdAt >= :dateStart")
            ->andWhere("dr.createdAt <= :dateEnd")
            ->setParameter("statuses", $statuses)
            ->setParameter("dateStart", $startAt)
            ->setParameter("dateEnd", $endAt)
            ->getQuery()
            ->getScalarResult();
    }
}