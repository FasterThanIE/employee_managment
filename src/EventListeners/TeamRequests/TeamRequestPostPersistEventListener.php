<?php

namespace App\EventListeners\TeamRequests;

use App\Entity\Logs\TeamMemberRequestsLog;
use App\Entity\TeamMemberRequests;
use App\Exceptions\InvalidRequestStatusException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TeamRequestPostPersistEventListener
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
     * @param LifecycleEventArgs $eventArgs
     * @throws InvalidRequestStatusException
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getObject();

        if (!$entity instanceof TeamMemberRequests) {
            return;
        }

        $this->log($entity);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @throws InvalidRequestStatusException
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getObject();

        if (!$entity instanceof TeamMemberRequests) {
            return;
        }

        $this->log($entity);
    }

    /**
     * @param TeamMemberRequests $entity
     * @throws InvalidRequestStatusException
     */
    private function log(TeamMemberRequests $entity): void
    {
        $requestLog = new TeamMemberRequestsLog();
        $requestLog->setUserId($entity->getUserId());
        $requestLog->setTeamId($entity->getTeamId());
        $requestLog->setAppliedOn($entity->getAppliedOn());
        $requestLog->setStatus($entity->getActionTo());
        $requestLog->setRequestId($entity->getId());
        $requestLog->setUpdatedOn(new DateTime());
        $requestLog->setUpdatedBy($entity->getUpdatedBy());
        $this->em->persist($requestLog);
        $this->em->flush();
    }

}