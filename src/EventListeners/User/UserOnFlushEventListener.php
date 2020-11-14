<?php

namespace App\EventListeners\User;

use App\Document\UserLog;
use App\Entity\User;
use App\Models\LogPool;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ORM\Event\OnFlushEventArgs;

class UserOnFlushEventListener
{
    /**
     * @var DocumentManager
     */
    private $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @param OnFlushEventArgs $args
     * @throws MongoDBException
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $entities = $em->getUnitOfWork();

        foreach ($entities->getScheduledEntityUpdates() as $entity) {
            if (!$entity instanceof User) {
                return;
            }
            $this->logData($entities, $entity);
        }

        $this->dm->flush();
    }

    private function logData($entities, $entity)
    {
        $changedData = $entities->getEntityChangeSet($entity);

        $pool = new LogPool($changedData);
        list($changedData, $keys) = $pool->getPool();

        $log = new UserLog();
        $log->setType(UserLog::USER_UPDATED);
        $log->setData($changedData);
        $log->setFields($keys);

        $this->dm->persist($log);
    }
}