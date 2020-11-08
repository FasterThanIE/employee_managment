<?php

namespace App\Repository\Logs;

use App\Entity\Logs\TeamMemberRequestsLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamMemberRequestsLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamMemberRequestsLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamMemberRequestsLog[]    findAll()
 * @method TeamMemberRequestsLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamMemberRequestsLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamMemberRequestsLog::class);
    }

    // /**
    //  * @return TeamMemberRequestsLog[] Returns an array of TeamMemberRequestsLog objects
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
    public function findOneBySomeField($value): ?TeamMemberRequestsLog
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
