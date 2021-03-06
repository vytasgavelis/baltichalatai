<?php

namespace App\Repository;

use App\Entity\UserSpecialty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserSpecialty|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSpecialty|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSpecialty[]    findAll()
 * @method UserSpecialty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSpecialtyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSpecialty::class);
    }

    // /**
    //  * @return UserSpecialty[] Returns an array of UserSpecialty objects
    //  */
    public function findByUserIdAndSpecialtyId($userId, $specialtyId)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.userId = :userId')
            ->andWhere('u.specialtyId = :specialtyId')
            ->setParameter('specialtyId', $specialtyId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return UserSpecialty[] Returns an array of UserSpecialty objects
    //  */
    public function findBySpecialty($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return UserSpecialty[] Returns an array of UserSpecialty objects
    //  */
    public function findBySpecialtyAndCity($specialty, $city)
    {
        return $this->createQueryBuilder('u')
            ->from('App\Entity\UserInfo', 'info')
            ->leftJoin('info.userId', 'userId')
            ->andWhere('u.specialtyId = :specialty')
            ->andWhere('info.city = :city')
            ->setParameter('city', $city)
            ->setParameter('specialty', $specialty)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return UserSpecialty[] Returns an array of UserSpecialty objects
    //  */
    public function findBySpecialtyAndName($specialty, $name)
    {
        return $this->createQueryBuilder('u')
            ->from('App\Entity\UserInfo', 'info')
            ->leftJoin('info.userId', 'userId')
            ->andWhere('u.specialtyId = :specialty')
            ->andWhere('info.name like :name')
            ->setParameter('name', $name)
            ->setParameter('specialty', $specialty)
            ->getQuery()
            ->getResult();
    }
}
