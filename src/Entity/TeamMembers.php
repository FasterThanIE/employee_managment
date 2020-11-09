<?php

namespace App\Entity;

use App\Exceptions\InvalidMemberRoleException;
use App\Repository\TeamMembersRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamMembersRepository::class)
 */
class TeamMembers
{

    /**
     * ==========================================
     * Roles
     * Add any roles that you add to VALID_ROLES. This constant is used to check if ROLE is valid or not
     */
    const VALID_ROLES = [
        self::ROLE_MEMBER, self::ROLE_ADMINISTRATOR, self::ROLE_FOUNDER
    ];
    const ROLE_MEMBER = "member";
    const ROLE_ADMINISTRATOR = "admin";
    const ROLE_FOUNDER = "founder";
    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="members")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    protected $team;
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var int
     * @ORM\Column(name="team_id", type="integer")
     */
    private $teamId;
    /**
     * @var int
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;
    /**
     * @var DateTime
     * @ORM\Column(name="joined_on", type="datetime")
     */
    private $joinedOn;
    /**
     * @var string
     * @ORM\Column(name="role", type="string", length=20)
     */
    private $role;

    public function __construct()
    {
        $this->joinedOn = new DateTime();
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @throws InvalidMemberRoleException
     */
    public function setRole(string $role): void
    {
        if (!self::isValidRole($role)) {
            throw new InvalidMemberRoleException("Invalid role used " . $role);
        }
        $this->role = $role;
    }

    /**
     * @param string $role
     * @return bool
     */
    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::VALID_ROLES);
    }

    /**
     * @return DateTime
     */
    public function getJoinedOn(): DateTime
    {
        return $this->joinedOn;
    }

    /**
     * @param DateTime $joinedOn
     */
    public function setJoinedOn(DateTime $joinedOn): void
    {
        $this->joinedOn = $joinedOn;
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

    public function getId(): ?int
    {
        return $this->id;
    }
}
