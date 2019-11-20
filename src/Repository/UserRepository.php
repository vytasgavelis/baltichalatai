<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of Users objects
    //  */

    public function findByIdAndRole($id, $role)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :id')
            ->andWhere('u.role = :role')
            ->setParameter('id', $id)
            ->setParameter('role', $role)
            ->getQuery()
            ->getResult();
    }

    public function search(string $name = null, string $city = null, int $specialty = null)
    {
        return $this->createQueryBuilder('u')
            ->select('u, us, spec')
            ->join('u.userInfo', 'us')
            ->join('u.userSpecialties', 'spec')
            ->where('us.name like :name')
            ->andWhere('us.city like :city')
            ->andWhere('spec.specialtyId = :specId')
            ->andWhere('u.role = 2')
            ->setParameters(['name' => '%'.$name.'%', 'city' => '%'.$city.'%', 'specId' => $specialty])
            ->getQuery()
            ->getResult();
    }

    public function getUsers()
    {
        return $this->getEntityManager()->getRepository(User::class)->findBy(['role' => 1]);
    }

    public function getSpecialists()
    {
        return $this->getEntityManager()->getRepository(User::class)->findBy(['role' => 2]);
    }

    public function getClinics()
    {
        return $this->getEntityManager()->getRepository(User::class)->findBy(['role' => 3]);
    }
}
