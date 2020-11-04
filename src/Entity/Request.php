<?php

namespace App\Entity;

use App\Exceptions\InvalidCategoryException;
use App\Exceptions\InvalidTypeException;
use App\Repository\RequestsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestsRepository::class)
 * @ORM\Table(name="requests")
 */
class Request
{

    /**
     * ==========================================
     * Statuses
     * Add any statuses that you add to VALID_STATUSES. This constant is used to check if status is valid or not
     */
    const VALID_STATUSES = [
        self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED,
    ];
    const STATUS_PENDING    = "pending";
    const STATUS_APPROVED   = "approved";
    const STATUS_REJECTED   = "rejected";


    /**
     * ==========================================
     * Types
     * Add any types that you add to VALID_TYPES. This constant is used to check if TYPE is valid or not
     */
    const VALID_TYPES = [
        self::TYPE_VACATION, self::TYPE_SICK_LEAVE, self::TYPE_PARENTAL_LEAVE,
        self::TYPE_JURY_DUTY, self::TYPE_PERSONAL_TIME, self::TYPE_VOTING,
        self::TYPE_HOLIDAYS, self::TYPE_MILITARY_LEAVE, self::TYPE_BEREAVEMENT,
    ];

    const TYPE_VACATION             = "vacation";
    const TYPE_SICK_LEAVE           = "sick";
    const TYPE_PARENTAL_LEAVE       = "parental";
    const TYPE_JURY_DUTY            = "jury_duty";
    const TYPE_PERSONAL_TIME        = "personal";
    const TYPE_VOTING               = "voting";
    const TYPE_HOLIDAYS             = "holidays";
    const TYPE_MILITARY_LEAVE       = "military";
    const TYPE_BEREAVEMENT          = "bereavement"; // ex: Incase of death of a family member etc..

    /**
     * ==========================================
     * Categories
     * Add any categories that you add to VALID_CATEGORIES. This constant is used to check if CATEGORY is valid or not
     */
    const VALID_CATEGORIES = [
        self::PAID_LEAVE, self::UNPAID_LEAVE,
    ];
    const PAID_LEAVE                = "paid";
    const UNPAID_LEAVE              = "unpaid";


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $team_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $status = self::STATUS_PENDING;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdOn;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedOn;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $updatedBy;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $category;


    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="start_date")
     */
    private $startDate;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="end_date")
     */
    private $endDate;

    /**
     * @return int
     */
    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     */
    public function setUpdatedBy(int $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->team_id;
    }

    /**
     * @param int $team_id
     */
    public function setTeamId(int $team_id): void
    {
        $this->team_id = $team_id;
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
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @param DateTime $createdOn
     */
    public function setCreatedOn(DateTime $createdOn): void
    {
        $this->createdOn = $createdOn;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedOn(): ?DateTime
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn(DateTime $updatedOn): void
    {
        $this->updatedOn = $updatedOn;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws InvalidTypeException
     */
    public function setType(string $type): void
    {
        if(!$this->isValidType($type))
        {
            throw new InvalidTypeException("Invalid type encountered ".$type);
        }
        $this->type = $type;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function isValidType(string $type) : bool
    {
        return in_array($type, self::VALID_TYPES);
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @throws InvalidCategoryException
     */
    public function setCategory(string $category): void
    {
        if(!$this->isValidCategory($category))
        {
            throw new InvalidCategoryException("Invalid category encountered ".$category);
        }
        $this->category = $category;
    }


    /**
     * @param string $category
     * @return bool
     */
    public function isValidCategory(string $category): bool
    {
        return in_array($category, self::VALID_CATEGORIES);
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }


}
