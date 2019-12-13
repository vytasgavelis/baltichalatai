<?php


namespace App\Services;

use App\Entity\User;

class UserAuthService
{
    /**
     * @param User $user
     * @return bool
     */
    public function isSpecialist(User $user)
    {
        return $user instanceof User && $user->getRole() == 2;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isPatient(User $user)
    {
        return $user instanceof User && $user->getRole() == 1;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isClinic(User $user)
    {
        return $user instanceof User && $user->getRole() == 3;
    }
}
