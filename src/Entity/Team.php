<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\AlreadyOwnsTeamValidator;

/**
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 */
class Team
{

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
     * @var TeamMembers
     * @ORM\OneToMany(targetEntity="TeamMembers", mappedBy="team")
     * @ORM\JoinColumn(name="id", referencedColumnName="team_id")
     */
    protected $members;


    public function __construct()
    {
        $this->createdOn = new DateTime();
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
}
