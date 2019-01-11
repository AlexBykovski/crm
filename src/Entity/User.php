<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="role", type="string")
 * @ORM\DiscriminatorMap({"ROLE_MANAGER" = "Manager", "ROLE_LOGISTICIAN" = "Logistician", "ROLE_PRINTER" = "Printer"})
 */
abstract class User extends BaseUser
{
    const ROLE_MANAGER = "ROLE_MANAGER";
    const ROLE_LOGISTICIAN = "ROLE_LOGISTICIAN";
    const ROLE_PRINTER = "ROLE_PRINTER";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}

