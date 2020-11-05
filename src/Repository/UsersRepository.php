<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param string $olderThan
     * @return QueryBuilder
     * @throws Exception
     */
    public function getUsersOlderThan(string $olderThan)
    {
        return $this->createQueryBuilder('u')
            ->where('u.registrationDate < :olderThan')
            ->andWhere('u.status = :status')
            ->setParameter(":olderThan", new \DateTime($olderThan))
            ->setParameter(":status", User::USER_STATUS_ACTIVE)
            ->getQuery()
            ->getResult();
    }

}
