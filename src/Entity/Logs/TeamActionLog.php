<?php

namespace App\Entity\Log;

use App\Repository\Logs\TeamActionLogRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamActionLogRepository::class)
 */
class TeamActionLog
{
    /**
     * ==========================================
     * Actions
     * Add any actions that you add to VALID_ACTIONS. This constant is used to check if ACTION is valid or not
     */
    const VALID_ACTIONS = [
        self::ACTION_CREATED, self::ACTION_ARCHIVED, self::ACTION_DELETED,
        self::ACTION_RENAMED,
    ];
    const ACTION_CREATED = "created";
    const ACTION_DELETED = "deleted";
    const ACTION_ARCHIVED = "archived";
    const ACTION_RENAMED = "banned";

    /**
     * @var int
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
     * @var string
     * @ORM\Column(name="action", type="string", length=20)
     */
    private $action;

    /**
     * @var DateTime
     * @ORM\Column(name="action_date", type="datetime")
     */
    private $actionDate;

    /**
     * @var int
     * @ORM\Column(name="action_by", type="integer")
     */
    private $actionBy;

    /**
     * @var string
     * @ORM\Column(name="content", type="datetime", nullable=true)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
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
     * @return DateTime
     */
    public function getActionDate(): DateTime
    {
        return $this->actionDate;
    }

    /**
     * @param DateTime $actionDate
     */
    public function setActionDate(DateTime $actionDate): void
    {
        $this->actionDate = $actionDate;
    }

    /**
     * @return int
     */
    public function getActionBy(): int
    {
        return $this->actionBy;
    }

    /**
     * @param int $actionBy
     */
    public function setActionBy(int $actionBy): void
    {
        $this->actionBy = $actionBy;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
