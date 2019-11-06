<?php

namespace App\Repository;

use App\Entity\ClinicInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ClinicInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClinicInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClinicInfo[]    findAll()
 * @method ClinicInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClinicInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClinicInfo::class);
    }

    // /**
    //  * @return ClinicInfo[] Returns an array of ClinicInfo objects
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
    public function findOneBySomeField($value): ?ClinicInfo
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
