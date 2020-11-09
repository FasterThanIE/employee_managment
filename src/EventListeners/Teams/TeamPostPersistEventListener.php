<?php

namespace App\EventListeners\Teams;

use App\Entity\Log\TeamActionLog;
use App\Entity\Team;
use App\Entity\TeamMembers;
use App\Entity\User;
use App\Exceptions\InvalidMemberRoleException;
use App\Exceptions\User\InvalidUserRoleException;
use App\Exceptions\User\InvalidUserStatusException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TeamPostPersistEventListener
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param LifecycleEventArgs $event
     * @throws InvalidUserRoleException|InvalidUserStatusException|InvalidMemberRoleException
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();

        if(!$entity instanceof Team)
        {
            return;
        }

        $this->updateUser($entity->getUser());
        $this->addMember($entity);
        $this->logAction($entity);

        $this->em->flush();
    }

    private function logAction(Team $team): void
    {
        $log = new TeamActionLog();
        $log->setTeamId($team->getId());
        $log->setAction($team->getAction());
        $log->setActionBy($team->getUser()->getId());
        $log->setActionDate(new DateTime());
        $this->em->persist($log);
    }

    /**
     * @param User $user
     * @throws InvalidUserRoleException
     * @throws InvalidUserStatusException
     */
    private function updateUser(User $user): void
    {
        $user->setStatus(User::USER_STATUS_ACTIVE);
        $user->setRole(User::ROLE_NORMAL);
        $this->em->persist($user);
    }

    /**
     * @param Team $team
     * @throws InvalidMemberRoleException
     */
    private function addMember(Team $team): void
    {
        $members = new TeamMembers();
        $members->setTeam($team);
        $members->setRole(TeamMembers::ROLE_FOUNDER);
        $members->setUser($team->getUser());
        $this->em->persist($members);
    }


}