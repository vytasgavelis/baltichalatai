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

    /**
     * @param int $value
     * @param int $clinicId
     * @return mixed
     */

    public function findBySpecialistIdAndClinicId(int $value, int $clinicId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.specialistId = :val')
            ->andWhere('c.clinicId = :clinicId')
            ->setParameter('val', $value)
            ->setParameter('clinicId', $clinicId)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $id
     * @return \Doctrine\ORM\Query
     */
    public function findByClinicIdQueryBuilder(int $id)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.clinicId = :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'ASC')
            ->getQuery();
    }

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
