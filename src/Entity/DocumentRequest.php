<?php

namespace App\Entity;

use DateInterval;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRequestRepository")
 * @ORM\Table(name="document_request")
 */
class DocumentRequest
{
    const BUDGET = [
        "3 месяца" => "2000",
        "1 год" => "2500",
        "3 года" => "3500",
        "5 лет" => "4500",
    ];

    const END_REGISTRATION = [
        "3 месяца" => "P3M",
        "1 год" => "P1Y",
        "3 года" => "P3Y",
        "5 лет" => "P5Y",
    ];

    const STATUSES_VIEW = [
        self::STATUS_NOT_HANDLED => "Не обработана",
        self::STATUS_CONFIRM_REQUEST_DELIVERY => "Подтверждение заказа и доставки",
        self::STATUS_PREPARE_DOCUMENTS => "Подготовка документов",
        self::STATUS_MOVE_TO_PRINT => "Отправил на распечатку",
        self::STATUS_REJECT => "Отказ",
        self::STATUS_PRINTED => "Распечатано",
        self::STATUS_COURIER => "Курьер",
        self::STATUS_TRANSPOSITION => "Перенос",
        self::STATUS_PAYMENT => "Оплата",
    ];

    const MANAGER_STATUSES = [
        DocumentRequest::STATUS_NOT_HANDLED => "Не обработана",
        DocumentRequest::STATUS_CONFIRM_REQUEST_DELIVERY => "Подтверждение заказа и доставки",
        DocumentRequest::STATUS_PREPARE_DOCUMENTS => "Подготовка документов",
        DocumentRequest::STATUS_MOVE_TO_PRINT => "Отправил на распечатку",
        DocumentRequest::STATUS_REJECT => "Отказ",
    ];

    const PRINTER_STATUSES = [
        DocumentRequest::STATUS_PRINTED => "Распечатано",
        DocumentRequest::STATUS_COURIER => "Курьер",
        DocumentRequest::STATUS_REJECT => "Отказ",
    ];

    const LOGISTICIAN_STATUSES = [
        DocumentRequest::STATUS_TRANSPOSITION => "Перенос",
        DocumentRequest::STATUS_PAYMENT => "Оплата",
        DocumentRequest::STATUS_REJECT => "Отказ",
    ];

    const STATUS_NOT_HANDLED = "STATUS_NOT_HANDLED";
    const STATUS_CONFIRM_REQUEST_DELIVERY = "STATUS_CONFIRM_REQUEST_DELIVERY";
    const STATUS_PREPARE_DOCUMENTS = "STATUS_PREPARE_DOCUMENTS";
    const STATUS_MOVE_TO_PRINT = "STATUS_MOVE_TO_PRINT";
    const STATUS_REJECT = "STATUS_REJECT";
    const STATUS_PRINTED = "STATUS_PRINTED";
    const STATUS_COURIER = "STATUS_COURIER";
    const STATUS_TRANSPOSITION = "STATUS_TRANSPOSITION";
    const STATUS_PAYMENT = "STATUS_PAYMENT";

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
    private $series;

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
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $responsibleManager;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $budget;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $isBackDating = 0;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registerFrom;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registerTo;

    /**
     * @Assert\Valid()
     *
     * @var DeliveryDetail
     *
     * @ORM\OneToOne(targetEntity="DeliveryDetail", mappedBy="documentRequest", cascade={"persist", "remove"})
     */
    private $deliveryDetail;

    /**
     * @Assert\Valid()
     *
     * @var DocumentDetail
     *
     * @ORM\OneToOne(targetEntity="DocumentDetail", mappedBy="documentRequest", cascade={"persist", "remove"})
     */
    private $documentDetail;

    /**
     * DocumentRequest constructor.
     * @param null|string $fio
     * @param null|string $citizen
     * @param DateTime|null $birthDate
     * @param null|string $birthPlace
     * @param null|string $type
     * @param null|string $series
     * @param null|string $number
     * @param DateTime|null $issuedDate
     * @param null|string $issuedAuthority
     * @param null|string $term
     * @param null|string $comment
     * @param null|string $phone
     *
     * @throws \Exception
     */
    public function __construct(?string $fio, ?string $citizen, ?DateTime $birthDate, ?string $birthPlace,
                                ?string $type, ?string $series, ?string $number, ?DateTime $issuedDate,
                                ?string $issuedAuthority, ?string $term, ?string $comment, ?string $phone)
    {
        $this->fio = $fio;
        $this->citizen = $citizen;
        $this->birthDate = $birthDate;
        $this->birthPlace = $birthPlace;
        $this->type = $type;
        $this->series = $series;
        $this->number = $number;
        $this->issuedDate = $issuedDate;
        $this->issuedAuthority = $issuedAuthority;
        $this->term = $term;
        $this->comment = $comment;
        $this->phone = $phone;
        $this->status = self::STATUS_NOT_HANDLED;
        $this->createdAt = new DateTime();

        if(array_key_exists($term, self::BUDGET)){
            $this->budget = self::BUDGET[$term];

            $this->registerFrom = new DateTime();
            $this->registerTo = new DateTime();
            $this->registerFrom->add(new DateInterval("P1D"));
            $this->registerTo->add(new DateInterval(self::END_REGISTRATION[$term]));
        }

        $this->deliveryDetail = new DeliveryDetail($this);
        $this->documentDetail = new DocumentDetail($this);
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
    public function getSeries(): ?string
    {
        return $this->series;
    }

    /**
     * @param null|string $series
     */
    public function setSeries(?string $series): void
    {
        $this->series = $series;
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
     * @return null|string
     */
    public function getResponsibleManager(): ?string
    {
        return $this->responsibleManager;
    }

    /**
     * @param null|string $responsibleManager
     */
    public function setResponsibleManager(?string $responsibleManager): void
    {
        $this->responsibleManager = $responsibleManager;
    }

    /**
     * @return null|string
     */
    public function getBudget(): ?string
    {
        return $this->budget;
    }

    /**
     * @param null|string $budget
     */
    public function setBudget(?string $budget): void
    {
        $this->budget = $budget;
    }

    /**
     * @return bool
     */
    public function isBackDating(): bool
    {
        return $this->isBackDating;
    }

    /**
     * @param bool $isBackDating
     */
    public function setIsBackDating(bool $isBackDating): void
    {
        $this->isBackDating = $isBackDating;
    }

    /**
     * @return DateTime|null
     */
    public function getRegisterFrom(): ?DateTime
    {
        return $this->registerFrom;
    }

    /**
     * @param DateTime|null $registerFrom
     */
    public function setRegisterFrom(?DateTime $registerFrom): void
    {
        $this->registerFrom = $registerFrom;
    }

    /**
     * @return DateTime|null
     */
    public function getRegisterTo(): ?DateTime
    {
        return $this->registerTo;
    }

    /**
     * @param DateTime|null $registerTo
     */
    public function setRegisterTo(?DateTime $registerTo): void
    {
        $this->registerTo = $registerTo;
    }

    /**
     * @return DeliveryDetail
     */
    public function getDeliveryDetail(): DeliveryDetail
    {
        return $this->deliveryDetail;
    }

    /**
     * @param DeliveryDetail $deliveryDetail
     */
    public function setDeliveryDetail(DeliveryDetail $deliveryDetail): void
    {
        $this->deliveryDetail = $deliveryDetail;
    }

    /**
     * @return DocumentDetail
     */
    public function getDocumentDetail(): DocumentDetail
    {
        return $this->documentDetail;
    }

    /**
     * @param DocumentDetail $documentDetail
     */
    public function setDocumentDetail(DocumentDetail $documentDetail): void
    {
        $this->documentDetail = $documentDetail;
    }

    /**
     * @return string
     */
    public function getViewStatus()
    {
        return self::STATUSES_VIEW[$this->status];
    }

    public function getRegistrationTerm()
    {
        if(!$this->isBackDating || !$this->registerFrom || !$this->registerTo){
            return $this->term;
        }

        return $this->registerFrom->format("d.m.Y") . ' - ' . $this->registerTo->format("d.m.Y");
    }
}