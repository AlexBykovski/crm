<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="logistician")
 */
class Logistician extends User
{
    public function __construct()
    {
        parent::__construct();

        $this->addRole(User::ROLE_LOGISTICIAN);
    }

    public function getSearchStatuses()
    {
        $statuses = array_keys(DocumentRequest::LOGISTICIAN_STATUSES);

        //$statuses[] = DocumentRequest::STATUS_MOVE_TO_PRINT;

        return $statuses;
    }

    public function getRole()
    {
        return User::ROLE_LOGISTICIAN;
    }
}