<?php


namespace App\Services;

use App\Entity\Specialty;
use App\Entity\User;
use App\Entity\UserSpecialty;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class UserSpecialtyService
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var FlashBagInterface
     */
    private $bag;

    /**
     * UserSpecialtyService constructor.
     * @param EntityManagerInterface $manager
     * @param FlashBagInterface $bag
     */
    public function __construct(EntityManagerInterface $manager, FlashBagInterface $bag)
    {
        $this->manager = $manager;
        $this->bag = $bag;
    }

    /**
     * @param $specialtyData
     * @param User $user
     */
    public function addSpecialty($specialtyData, User $user)
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

                $this->bag->add('success', 'Specialybė pridėta.');
            } else {
                $this->bag->add('error', 'Jūs jau esate pasirinkęs šią specialybę.');
            }
        }
//        } elseif ($customSpecialtyData != "") {// Add specialty from text box.
//            // Check if specialty already exists.
//            $specialty = $this->manager->getRepository(Specialty::class)
//                ->findBySpecialtyName($customSpecialtyData);
//
//            if (sizeof($specialty) == 0) {
//                $userSpecialty = new UserSpecialty();
//                $specialty = new Specialty();
//                $specialty->setName($customSpecialtyData);
//
//                $this->manager->persist($specialty);
//
//                $userSpecialty->setUserId($user);
//                $userSpecialty->setSpecialtyId($specialty);
//                $this->manager->persist($userSpecialty);
//                $this->manager->flush();
//            } else {
//                // Flash message that specialty already exists
//                echo 'specialty already exists';
//            }
//        }
    }
}
