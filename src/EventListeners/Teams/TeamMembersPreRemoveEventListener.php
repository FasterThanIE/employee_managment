<?php

namespace App\EventListeners\Teams;

use App\Entity\TeamMembers;
use App\Entity\User;
use App\Exceptions\User\InvalidUserRoleException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TeamMembersPreRemoveEventListener
{

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param LifecycleEventArgs $lifecycleEventArgs
     * @throws InvalidUserRoleException
     */
    public function preRemove(LifecycleEventArgs $lifecycleEventArgs)
    {
        $entity = $lifecycleEventArgs->getObject();

        if (!$entity instanceof TeamMembers) {
            return;
        }

        $user = $entity->getUser();
        $user->setRole(User::ROLE_PENDING);
        $this->em->persist($user);
        $this->em->flush();
    }

}