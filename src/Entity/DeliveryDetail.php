<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="delivery_detail")
 */
class DeliveryDetail
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
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveryDate;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveryTime;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $station;

    /**
     * @var DocumentRequest
     *
     * @ORM\OneToOne(targetEntity="DocumentRequest", inversedBy="deliveryDetail")
     * @ORM\JoinColumn(name="document_request_id", referencedColumnName="id")
     */
    private $documentRequest;

    /**
     * DeliveryDetail constructor.
     *
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
     * @return DateTime|null
     */
    public function getDeliveryDate(): ?DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * @param DateTime|null $deliveryDate
     */
    public function setDeliveryDate(?DateTime $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveryTime(): ?DateTime
    {
        return $this->deliveryTime;
    }

    /**
     * @param DateTime|null $deliveryTime
     */
    public function setDeliveryTime(?DateTime $deliveryTime): void
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return null|string
     */
    public function getStation(): ?string
    {
        return $this->station;
    }

    /**
     * @param null|string $station
     */
    public function setStation(?string $station): void
    {
        $this->station = $station;
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