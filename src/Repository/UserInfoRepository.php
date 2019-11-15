<?php

namespace App\Repository;

use App\Entity\UserInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInfo[]    findAll()
 * @method UserInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInfo::class);
    }

    // /**
    //  * @return UserInfo[] Returns an array of UserInfo objects
    //  */

    public function findByUserId($value): ?UserInfo
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.userId = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByUserName($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserNameAndCity($name, $city)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name like :name and u.city like :city')
            ->setParameter('name', '%' . $name . '%')
            ->setParameter('city', '%' . $city . '%')
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserCity($value)
    {
        echo 'search by cite';
        return $this->createQueryBuilder('u')
            ->from('App\Entity\User', 'usr')
//            ->leftJoin('usr.role', 'userId')
//            ->andWhere('usr.role = 1')
            ->andWhere('u.city like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?UserInfo
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
