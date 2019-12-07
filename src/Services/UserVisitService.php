<?php


namespace App\Services;

use App\Entity\Recipe;
use App\Entity\SendingToDoctor;
use App\Entity\UserVisit;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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

    /**
     * @param UserVisit $visit
     * @param string $visitDesc
     */
    public function saveVisitInfo(UserVisit $visit, string $visitDesc): void
    {
        $visit->setDescription($visitDesc);
        $this->manager->persist($visit);
        $this->manager->flush($visit);
    }

    /**
     * @param UserVisit $visit
     * @param string $recipeDesc
     * @param string $recipeDuration
     * @throws Exception
     */
    public function saveRecipeInfo(UserVisit $visit, string $recipeDesc, string $recipeDuration): void
    {
        $recipe = $visit->getRecipeId() ?? new Recipe();
        $recipe->setValidFrom(new DateTime());
        $recipe->setDescription($recipeDesc);
        $recipe->setValidDuration($recipeDuration);
        $this->manager->persist($recipe);

        $visit->setRecipeId($recipe);
        $this->manager->persist($visit);

        $this->manager->flush();
    }

    /**
     * @param UserVisit $visit
     * @param string $sendingToDoctorDesc
     */
    public function saveSendingToDoctorInfo(UserVisit $visit, string $sendingToDoctorDesc): void
    {
        $sendingToDoctor = $visit->getSendingToDoctorId() ?? new SendingToDoctor();
        $sendingToDoctor->setClientId($visit->getClientId());
        $sendingToDoctor->setSpecialistId($visit->getSpecialistId());
        $sendingToDoctor->setDescription($sendingToDoctorDesc);
        $this->manager->persist($sendingToDoctor);

        $visit->setSendingToDoctorId($sendingToDoctor);
        $this->manager->persist($visit);

        $this->manager->flush();
    }
}
