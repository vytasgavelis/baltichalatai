<?php


namespace App\Services;

use App\Entity\Specialty;
use App\Entity\UserSpecialty;
use Doctrine\ORM\EntityManagerInterface;

class UserSpecialtyService
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserSpecialtyService constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function addSpecialty($specialtyData, $customSpecialtyData, $user)
    {
        // Add specialty from dropdown
        if ($specialtyData != "") {
            //Check if user does not have that specialty
            $userSpecialties = $this->manager->getRepository(UserSpecialty::class)
                ->findByUserIdAndSpecialtyId($user->getId(), $specialtyData);

            if (sizeof($userSpecialties) == 0) {
                $userSpecialty = new UserSpecialty();
                $userSpecialty->setUserId($user);
                $specialty = $this->manager->getRepository(Specialty::class)
                    ->findOneById($specialtyData);
                $userSpecialty->setSpecialtyId($specialty);

                $this->manager->persist($userSpecialty);
                $this->manager->flush();
            } else {
                // Flash message that you already have that specialty added.
                echo 'jus jau pasirinkes tokia specialybe';
            }
        } elseif ($customSpecialtyData != "") {// Add specialty from text box.
            // Check if specialty already exists.
            $specialty = $this->manager->getRepository(Specialty::class)
                ->findBySpecialtyName($customSpecialtyData);

            if (sizeof($specialty) == 0) {
                $userSpecialty = new UserSpecialty();
                $specialty = new Specialty();
                $specialty->setName($customSpecialtyData);

                $this->manager->persist($specialty);
                $this->manager->flush();

                $userSpecialty->setUserId($user);
                $userSpecialty->setSpecialtyId($specialty);
                $this->manager->persist($userSpecialty);
                $this->manager->flush();
            } else {
                // Flash message that specialty already exists
                echo 'specialty already exists';
            }
        }
    }
}
