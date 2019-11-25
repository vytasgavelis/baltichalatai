<?php

namespace App\Repository;

use App\Entity\Specialty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Specialty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Specialty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Specialty[]    findAll()
 * @method Specialty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialtyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Specialty::class);
    }

    // /**
    //  * @return Specialty[] Returns an array of Specialty objects
    //  */
    public function findBySpecialtyName($name)
    {
        $name = strtolower($name);

        return $this->createQueryBuilder('s')
            ->andWhere('LOWER(s.name) = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function findOneById($id): ?Specialty
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
