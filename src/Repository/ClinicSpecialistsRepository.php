<?php

namespace App\Repository;

use App\Entity\ClinicSpecialists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClinicSpecialists|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClinicSpecialists|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClinicSpecialists[]    findAll()
 * @method ClinicSpecialists[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClinicSpecialistsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClinicSpecialists::class);
    }

    // /**
    //  * @return ClinicSpecialists[] Returns an array of ClinicSpecialists objects
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
    public function findOneBySomeField($value): ?ClinicSpecialists
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
