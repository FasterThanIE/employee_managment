<?php

namespace App\Entity\Logs;

use App\Exceptions\InvalidRequestStatusException;
use App\Repository\Logs\TeamMemberRequestsLogRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamMemberRequestsLogRepository::class)
 */
class TeamMemberRequestsLog
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
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime
     * @ORM\Column(name="applied_on", type="datetime")
     */
    private $appliedOn;

    /**
     * @var DateTime
     * @ORM\Column(name="updated_on", type="datetime")
     */
    private $updatedOn;

    /**
     * @var int
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     * @ORM\Column(name="team_id", type="integer")
     */
    private $teamId;

    /**
     * @var string
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    /**
     * @var int
     * @ORM\Column(name="updated_by", type="integer")
     */
    private $updatedBy;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getAppliedOn(): DateTime
    {
        return $this->appliedOn;
    }

    /**
     * @param DateTime $appliedOn
     */
    public function setAppliedOn(DateTime $appliedOn): void
    {
        $this->appliedOn = $appliedOn;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }

    /**
     * @param int $teamId
     */
    public function setTeamId(int $teamId): void
    {
        $this->teamId = $teamId;
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
     * @throws InvalidRequestStatusException
     */
    public function setStatus(string $status): void
    {
        if(!self::isValidStatus($status))
        {
            throw new InvalidRequestStatusException("Invalid request status ".$status);
        }
        $this->status = $status;
    }

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
     * @param string $status
     * @return bool
     */
    public static function isValidStatus(string $status): bool
    {
        return in_array($status, self::VALID_STATUSES);
    }

    /**
     * @return DateTime
     */
    public function getUpdatedOn(): DateTime
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
}
