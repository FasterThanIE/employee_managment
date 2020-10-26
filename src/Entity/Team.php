<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $team_name;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdOn;

    /**
     * @var TeamRoles
     * @ORM\OneToMany(targetEntity="TeamRoles", mappedBy="team")
     * @ORM\JoinColumn(name="id", referencedColumnName="team_id")
     */
    private $roles;

    /**
     * @return TeamRoles
     */
    public function getRoles(): TeamRoles
    {
        return $this->roles;
    }

    /**
     * @param TeamRoles $roles
     */
    public function setRoles(TeamRoles $roles): void
    {
        $this->roles = $roles;
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
    public function getTeamName(): string
    {
        return $this->team_name;
    }

    /**
     * @param string $team_name
     */
    public function setTeamName(string $team_name): void
    {
        $this->team_name = $team_name;
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
