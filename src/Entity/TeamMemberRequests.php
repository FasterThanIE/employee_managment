<?php

namespace App\Entity;

use App\Repository\TeamMemberRequestsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamMemberRequestsRepository::class)
 */
class TeamMemberRequests
{
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
     * @ORM\OneToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

    public function __construct()
    {
        $this->appliedOn = new DateTime();
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
     * @return User
     */
    public function getUserId(): User
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
}
