<?php


namespace App\Services;

use App\Entity\UserVisit;
use Doctrine\ORM\EntityManagerInterface;

class UserVisitService
{

    private $manager;

    /**
     * SpecialistService constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param int $id
     */
    public function closeVisit(int $id)
    {
        $visit = $this->getVisitById($id);
        $this->changeVisitStatus($visit, '1');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getVisitById(int $id)
    {
        return $this->manager->getRepository(UserVisit::class)->getVisitById($id);
    }

    /**
     * @param UserVisit $visit
     * @param $status
     */
    public function changeVisitStatus(UserVisit $visit, $status)
    {
        $visit->setIsCompleted($status);
        $this->manager->persist($visit);
        $this->manager->flush();
    }
}
