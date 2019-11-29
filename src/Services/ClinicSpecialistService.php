<?php


namespace App\Services;


use App\Entity\ClinicSpecialists;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class ClinicSpecialistService
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

    public function addSpecialist(User $clinic, User $specialist)
    {
        // Check if specialist already belongs to clinic
        $clinicSpecialists = $this->manager->getRepository(ClinicSpecialists::class)
            ->findBySpecialistIdAndClinicId($specialist->getId(), $clinic->getId());
        if (sizeof($clinicSpecialists) == 0) {
            $clinicSpecialist = new ClinicSpecialists();
            $clinicSpecialist->setSpecialistId($specialist);
            $clinicSpecialist->setClinicId($clinic);

            $this->manager->persist($clinicSpecialist);
            $this->manager->flush();
        }
    }
}