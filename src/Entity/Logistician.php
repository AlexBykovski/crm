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
}