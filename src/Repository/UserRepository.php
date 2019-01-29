<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param int $userId
     * @return null|object
     */
    public function findOneWithTotalInvoices(int $userId): ?object
    {
        $result = $this->createQueryBuilder('u')
            ->select(
                'u.id',
                'u.email',
                'u.firstName',
                'u.lastName',
                'u.activated',
                'COUNT(i.id) as totalNumber',
                'SUM(i.amount) as totalAmount'
            )
            ->leftJoin('u.invoices', 'i')
            ->andWhere('u.id = :userId')
            ->addGroupBy('u.id')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();

        if (is_null($result)) {
            return null;
        }

        return (object) $result;
    }
}
