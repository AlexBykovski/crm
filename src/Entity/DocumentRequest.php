<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRequestRepository")
 * @ORM\Table(name="document_request")
 */
class DocumentRequest
{
    const STATUSES_VIEW = [
        "STATUS_NOT_HANDLED" => "НЕ ОБРАБОТАНА",
    ];

    const STATUS_NOT_HANDLED = "STATUS_NOT_HANDLED";

    /**
     * @var integer|null
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $citizen;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $birthPlace;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $number;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $issuedDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $issuedAuthority;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $term;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $comment;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * DocumentRequest constructor.
     * @param null|string $fio
     * @param null|string $citizen
     * @param DateTime|null $birthDate
     * @param null|string $birthPlace
     * @param null|string $type
     * @param null|string $number
     * @param DateTime|null $issuedDate
     * @param null|string $issuedAuthority
     * @param null|string $term
     * @param null|string $comment
     * @param null|string $phone
     */
    public function __construct(?string $fio, ?string $citizen, ?DateTime $birthDate, ?string $birthPlace, ?string $type, ?string $number, ?DateTime $issuedDate, ?string $issuedAuthority, ?string $term, ?string $comment, ?string $phone)
    {
        $this->fio = $fio;
        $this->citizen = $citizen;
        $this->birthDate = $birthDate;
        $this->birthPlace = $birthPlace;
        $this->type = $type;
        $this->number = $number;
        $this->issuedDate = $issuedDate;
        $this->issuedAuthority = $issuedAuthority;
        $this->term = $term;
        $this->comment = $comment;
        $this->phone = $phone;
        $this->status = self::STATUS_NOT_HANDLED;
        $this->createdAt = new DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getFio(): ?string
    {
        return $this->fio;
    }

    /**
     * @param null|string $fio
     */
    public function setFio(?string $fio): void
    {
        $this->fio = $fio;
    }

    /**
     * @return null|string
     */
    public function getCitizen(): ?string
    {
        return $this->citizen;
    }

    /**
     * @param null|string $citizen
     */
    public function setCitizen(?string $citizen): void
    {
        $this->citizen = $citizen;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime|null $birthDate
     */
    public function setBirthDate(?DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return null|string
     */
    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    /**
     * @param null|string $birthPlace
     */
    public function setBirthPlace(?string $birthPlace): void
    {
        $this->birthPlace = $birthPlace;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return null|string
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param null|string $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return DateTime|null
     */
    public function getIssuedDate(): ?DateTime
    {
        return $this->issuedDate;
    }

    /**
     * @param DateTime|null $issuedDate
     */
    public function setIssuedDate(?DateTime $issuedDate): void
    {
        $this->issuedDate = $issuedDate;
    }

    /**
     * @return null|string
     */
    public function getIssuedAuthority(): ?string
    {
        return $this->issuedAuthority;
    }

    /**
     * @param null|string $issuedAuthority
     */
    public function setIssuedAuthority(?string $issuedAuthority): void
    {
        $this->issuedAuthority = $issuedAuthority;
    }

    /**
     * @return null|string
     */
    public function getTerm(): ?string
    {
        return $this->term;
    }

    /**
     * @param null|string $term
     */
    public function setTerm(?string $term): void
    {
        $this->term = $term;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getViewStatus()
    {
        return self::STATUSES_VIEW[$this->status];
    }
}