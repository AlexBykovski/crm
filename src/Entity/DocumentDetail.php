<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="document_detail")
 */
class DocumentDetail
{
    /**
     * @var integer|null
     *
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
    private $street;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $district;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $bossLastName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $department;

    /**
     * @var DocumentRequest
     *
     * @ORM\OneToOne(targetEntity="DocumentRequest", inversedBy="documentDetail")
     * @ORM\JoinColumn(name="document_request_id", referencedColumnName="id")
     */
    private $documentRequest;

    /**
     * DocumentDetail constructor.
     * @param DocumentRequest $documentRequest
     */
    public function __construct(DocumentRequest $documentRequest)
    {
        $this->documentRequest = $documentRequest;
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
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param null|string $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return null|string
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @param null|string $district
     */
    public function setDistrict(?string $district): void
    {
        $this->district = $district;
    }

    /**
     * @return null|string
     */
    public function getBossLastName(): ?string
    {
        return $this->bossLastName;
    }

    /**
     * @param null|string $bossLastName
     */
    public function setBossLastName(?string $bossLastName): void
    {
        $this->bossLastName = $bossLastName;
    }

    /**
     * @return null|string
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * @param null|string $department
     */
    public function setDepartment(?string $department): void
    {
        $this->department = $department;
    }

    /**
     * @return DocumentRequest
     */
    public function getDocumentRequest(): DocumentRequest
    {
        return $this->documentRequest;
    }

    /**
     * @param DocumentRequest $documentRequest
     */
    public function setDocumentRequest(DocumentRequest $documentRequest): void
    {
        $this->documentRequest = $documentRequest;
    }
}