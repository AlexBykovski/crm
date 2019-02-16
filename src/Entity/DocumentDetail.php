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
    private $bossFio;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $department;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $house;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $apartment;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $region;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $subway;

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
    public function getBossFio(): ?string
    {
        return $this->bossFio;
    }

    /**
     * @param null|string $bossFio
     */
    public function setBossFio(?string $bossFio): void
    {
        $this->bossFio = $bossFio;
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

    /**
     * @return null|string
     */
    public function getHouse(): ?string
    {
        return $this->house;
    }

    /**
     * @param null|string $house
     */
    public function setHouse(?string $house): void
    {
        $this->house = $house;
    }

    /**
     * @return null|string
     */
    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    /**
     * @param null|string $apartment
     */
    public function setApartment(?string $apartment): void
    {
        $this->apartment = $apartment;
    }

    /**
     * @return null|string
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param null|string $region
     */
    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return null|string
     */
    public function getSubway(): ?string
    {
        return $this->subway;
    }

    /**
     * @param null|string $subway
     */
    public function setSubway(?string $subway): void
    {
        $this->subway = $subway;
    }
}