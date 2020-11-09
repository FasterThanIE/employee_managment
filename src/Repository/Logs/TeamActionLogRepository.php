<?php

namespace App\Repository\Logs;

use App\Entity\TeamActionLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamActionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamActionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamActionLog[]    findAll()
 * @method TeamActionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamActionLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamActionLog::class);
    }

    // /**
    //  * @return TeamActionLog[] Returns an array of TeamActionLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamActionLog
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
