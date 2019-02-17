<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="printer")
 */
class Printer extends User
{
    public function __construct()
    {
        parent::__construct();

        $this->addRole(User::ROLE_PRINTER);
    }

    public function getSearchStatuses()
    {
        $statuses = array_keys(DocumentRequest::PRINTER_STATUSES);

//        $statuses[] = DocumentRequest::STATUS_MOVE_TO_PRINT;

        return $statuses;
    }

    public function getRole()
    {
        return User::ROLE_PRINTER;
    }
}