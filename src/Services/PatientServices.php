<?php


namespace App\Services;

use App\Entity\Recipe;
use App\Entity\UserVisit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PatientServices
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
     * @param UserInterface $user
     * @return mixed
     */
    public function getClientRecipes(UserInterface $user)
    {
        return $this->manager->getRepository(UserVisit::class)->getVisitsWithRecipesByClientId($user->getId());
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function getClientSendingsToDoctor(UserInterface $user)
    {
        return $this->manager->getRepository(UserVisit::class)->getVisitsWithSendingsByClientId($user->getId());
    }
}
