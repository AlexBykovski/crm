<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection
     *
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    protected $tasks;

    public function __construct()
    {
        parent::__construct();

        $this->tasks = new ArrayCollection();
    }

    public function getSearchStatuses(){}

    public function getRole(){}

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Collection $tasks
     */
    public function setTasks(Collection $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function addTask(Task $task)
    {
        $this->tasks->add($task);
    }
}

