<?php

namespace App\Entity;

use App\Exceptions\Teams\InvalidActionException;
use App\Exceptions\User\InvalidUserException;
use App\Repository\TeamsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 * @ORM\Table(name="teams")
 * @ORM\HasLifecycleCallbacks()
 */
class Team
{

    /**
     * @ORM\OneToMany(targetEntity="TeamMembers", mappedBy="team")
     * @ORM\JoinColumn(name="id", referencedColumnName="team_id")
     */
    protected $members;
    /**
     * @ORM\OneToMany(targetEntity="TeamMemberRequests", mappedBy="team")
     * @ORM\JoinColumn(name="id", referencedColumnName="team_id")
     */
    protected $memberRequests;
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @App\Validator\AlreadyOwnsTeam
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string", name="name", length=128, unique=true)
     */
    private $name;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdOn;
    /**
     * Not inserted into DB, user for the event listeners
     * @var null|User
     */
    private $user;

    /**
     * @var string
     */
    private $action;


    public function __construct()
    {
        $this->createdOn = new DateTime();
    }

    /**
     * @throws InvalidActionException
     * @throws InvalidUserException
     */
    public function prePersist()
    {
        if (!$this->getUser() instanceof User) {
            throw new InvalidUserException("Invalid user when creating a team. Please set a user when making new team");
        }
        if (!$this->getAction()) {
            throw new InvalidActionException("Action must be set when persisting a team. Check TeamActionLog for actions");
        }
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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

    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param TeamMembers $members
     */
    public function setMembers(TeamMembers $members): void
    {
        $this->members = $members;
    }

    /**
     * @return mixed
     */
    public function getMemberRequests()
    {
        return $this->memberRequests;
    }

    /**
     * @param mixed $memberRequests
     */
    public function setMemberRequests($memberRequests): void
    {
        $this->memberRequests = $memberRequests;
    }

}
