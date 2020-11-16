<?php

namespace App\Entity;

use App\Exceptions\Requests\InvalidRequestActionException;
use App\Exceptions\Requests\InvalidUpdatedByException;
use App\Exceptions\Requests\MissingRequestActionException;
use App\Repository\TeamMemberRequestsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamMemberRequestsRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class TeamMemberRequests
{
    /**
     * ==========================================
     * Actions
     * Add any actions that you add to VALID_ACTIONS. This constant is used to check if ACTION is valid or not
     */
    const VALID_ACTIONS = [
        self::ACTION_ACCEPTED, self::ACTION_DENIED, self::ACTION_PENDING,
    ];
    const ACTION_PENDING    = "pending";
    const ACTION_ACCEPTED   = "accepted";
    const ACTION_DENIED     = "denied";

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
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
     * @var Team
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    /**
     * @var int
     */
    private $updatedBy;

    /**
     * @var string
     */
    private $actionTo;

    public function __construct()
    {
        $this->appliedOn = new DateTime();
    }

    /**
     * @ORM\PrePersist()
     * @throws MissingRequestActionException
     * @throws InvalidUpdatedByException
     */
    public function prePersist()
    {
        if(!$this->getActionTo())
        {
            throw new MissingRequestActionException("Missing action for Member requests");
        }
        if(!$this->getUpdatedBy())
        {
            throw new InvalidUpdatedByException("Missing updated by for Memmber requests");
        }
    }

    /**
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team): void
    {
        $this->teamId = $team->getId();
        $this->team = $team;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->userId = $user->getId();
        $this->user = $user;
    }

    /**
     * Description: Must be able to return null, reason onFlush getting ID
     * @return int|null
     */
    public function getId(): ?int
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
     * @param User $userId
     */
    public function setUserId(User $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getActionTo(): string
    {
        return $this->actionTo;
    }

    /**
     * @param string $actionTo
     * @throws InvalidRequestActionException
     */
    public function setActionTo(string $actionTo): void
    {
        if(!$this->isValidAction($actionTo))
        {
            throw new InvalidRequestActionException();
        }
        $this->actionTo = $actionTo;
    }

    /**+
     * @param string $action
     * @return bool
     */
    public static function isValidAction(string $action): bool
    {
        return in_array($action, self::VALID_ACTIONS);
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
}
