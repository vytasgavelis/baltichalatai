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
        $query = $this->createQueryBuilder('u')
            ->select('u, us, spec')
            ->join('u.userInfo', 'us')
            ->join('u.userSpecialties', 'spec')
            ->where('concat(us.name, us.surname) like :name')
            ->andWhere('us.city like :city');

        if (!is_null($specialty)) {
            $query->andWhere('spec.specialtyId = :specId');
            $query->setParameters(['name' => '%' . $name . '%', 'city' => '%' . $city . '%', 'specId' => $specialty]);
        } else {
            $query->setParameters(['name' => '%' . $name . '%', 'city' => '%' . $city . '%']);
        }

        return $query->andWhere('u.role = 2')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string|null $name
     * @param string|null $city
     * @param int|null $specialty
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getWithSearchQueryBuilder(
        string $name = null,
        string $city = null,
        int $specialty = null
    ): \Doctrine\ORM\QueryBuilder {
        $query = $this->createQueryBuilder('u')
            ->select('u, us, spec')
            ->join('u.userInfo', 'us')
            ->join('u.userSpecialties', 'spec')
            ->where('concat(us.name, us.surname) like :name')
            ->andWhere('us.city like :city');

        if (!is_null($specialty)) {
            $query->andWhere('spec.specialtyId = :specId');
            $query->setParameters(['name' => '%' . $name . '%', 'city' => '%' . $city . '%', 'specId' => $specialty]);
        } else {
            $query->setParameters(['name' => '%' . $name . '%', 'city' => '%' . $city . '%']);
        }

        return $query->andWhere('u.role = 2');
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
