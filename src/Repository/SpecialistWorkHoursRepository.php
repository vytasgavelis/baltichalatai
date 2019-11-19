<?php

namespace App\Repository;

use App\Entity\SpecialistWorkHours;
use App\Entity\User;
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

    public function getWorkHours(User $user)
    {
        return $this->getEntityManager()->getRepository(SpecialistWorkHours::class)
            ->findBy(['specialistId' => $user->getId()]);
    }
}
