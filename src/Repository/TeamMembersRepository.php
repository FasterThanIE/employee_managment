<?php

namespace App\Repository;

use App\Entity\TeamMembers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamMembers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamMembers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamMembers[]    findAll()
 * @method TeamMembers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamMembersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamMembers::class);
    }

    // /**
    //  * @return TeamMembers[] Returns an array of TeamMembers objects
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
    public function findOneBySomeField($value): ?TeamMembers
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
