<?php

namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="manager")
 */
class Manager extends User
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $workUpdatedAt;

    public function __construct()
    {
        parent::__construct();

        $this->addRole(User::ROLE_MANAGER);
    }

    public function getSearchStatuses()
    {
        return array_keys(DocumentRequest::MANAGER_STATUSES);
    }

    public function getRole()
    {
        return User::ROLE_MANAGER;
    }

    /**
     * @return DateTime
     */
    public function getWorkUpdatedAt(): DateTime
    {
        return $this->workUpdatedAt;
    }

    /**
     * @param DateTime $workUpdatedAt
     */
    public function setWorkUpdatedAt(DateTime $workUpdatedAt): void
    {
        $this->workUpdatedAt = $workUpdatedAt;
    }
}