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
}