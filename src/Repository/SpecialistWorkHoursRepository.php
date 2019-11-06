<?php

namespace App\Repository;

use App\Entity\SpecialistWorkHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SpecialistWorkHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialistWorkHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialistWorkHours[]    findAll()
 * @method SpecialistWorkHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialistWorkHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialistWorkHours::class);
    }

    // /**
    //  * @return SpecialistWorkHours[] Returns an array of SpecialistWorkHours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SpecialistWorkHours
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
