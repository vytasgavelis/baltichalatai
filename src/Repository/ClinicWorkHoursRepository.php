<?php

namespace App\Repository;

use App\Entity\ClinicWorkHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClinicWorkHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClinicWorkHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClinicWorkHours[]    findAll()
 * @method ClinicWorkHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClinicWorkHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClinicWorkHours::class);
    }

    // /**
    //  * @return ClinicWorkHours[] Returns an array of ClinicWorkHours objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClinicWorkHours
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
