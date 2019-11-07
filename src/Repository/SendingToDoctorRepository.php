<?php

namespace App\Repository;

use App\Entity\SendingToDoctor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SendingToDoctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method SendingToDoctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method SendingToDoctor[]    findAll()
 * @method SendingToDoctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SendingToDoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SendingToDoctor::class);
    }

    // /**
    //  * @return SendingToDoctor[] Returns an array of SendingToDoctor objects
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
    public function findOneBySomeField($value): ?SendingToDoctor
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
