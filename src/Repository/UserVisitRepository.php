<?php

namespace App\Repository;

use App\Entity\UserVisit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserVisit|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserVisit|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserVisit[]    findAll()
 * @method UserVisit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserVisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserVisit::class);
    }

    public function findBySpecialistId($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.specialistId = :val')
            ->setParameter('val', $value)
            ->orderBy('u.visitDate', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function checkIfWorkHourExists($date, $specialistId, $clinicId)
    {
        return $this->getEntityManager()->getRepository(UserVisit::class)
            ->findBy([
                'specialistId' => $specialistId,
                'clinicId' => $clinicId,
                'visitDate' => $date
            ]);
    }
}
