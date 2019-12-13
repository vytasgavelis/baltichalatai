<?php


namespace App\Services;

use App\Entity\ClinicSpecialists;
use App\Entity\SpecialistWorkHours;
use App\Entity\User;
use App\Entity\UserVisit;
use Carbon\CarbonInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SpecialistService
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
     * @param array $workHours
     * @param int $page
     * @return array
     * @throws Exception
     */
    public function getSpecialistHoursFormatted(array $workHours, int $page): array
    {
        $dateArr = [];
        foreach ($workHours as $workHour) {
            $workDay = $workHour->getDay() + (($page - 1) * 7);
            $period = new DatePeriod(
                $workHour->getStartTime(),
                CarbonInterval::minutes(30),
                $workHour->getEndTime()->modify('+1 second')
            );
            $arr = [];
            foreach ($period as $d) {
                $formattedDate = $this->getDateFromDayNumber($workDay);
                $formattedTime = $d->format('H:i');
                if ($this->checkIfDateIsOccupied(
                    new DateTime($formattedDate . $formattedTime),
                    $workHour->getSpecialistId()->getId(),
                    $workHour->getClinicId()->getId()
                )) {
                    continue;
                } else {
                    $arr[] = $formattedTime;
                }
            }
            $dateArr[] = array(
                'clinicId' => $workHour->getClinicId(),
                array(
                    'day' => $workDay,
                    'hours' => $arr,
                ),
            );
        }

        return $dateArr;
    }

    /**
     * @param DateTime $date
     * @param int $specialistId
     * @param int $clinicId
     * @return bool
     */
    public function checkIfDateIsOccupied(DateTime $date, int $specialistId, int $clinicId)
    {
        return sizeof($this->manager->getRepository(UserVisit::class)
                ->checkIfWorkHourExists($date, $specialistId, $clinicId)) > 0;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSpecialist(int $id)
    {
        return $this->manager->getRepository(User::class)->findByIdAndRole($id, 2);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getClinic(int $id)
    {
        //return $this->manager->getRepository(User::class)->findByIdAndRole($id, 3);
        return $this->manager->getRepository(User::class)->findby(['id' => $id]);
    }

    /**
     * @param int $id
     * @return ClinicSpecialists[]|object[]
     */
    public function getSpecialistClinics(int $id)
    {
        return $this->manager->getRepository(ClinicSpecialists::class)->findBy(['specialistId' => $id]);
    }

    /**
     * @param User $specialist
     * @return SpecialistWorkHours[]|array|object[]
     */
    public function getSpecialistWorkHours(User $specialist)
    {
        return $this->manager->getRepository(SpecialistWorkHours::class)->getWorkHours($specialist);
    }

    /**
     * @return array
     */
    public function getWorkdayList(): array // galbut iskelt i kita service?
    {
        return ['Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis'];
    }


    /**
     * @param int $specId
     * @param int $clinicId
     * @return mixed
     */
    public function getWorkHours(int $specId, int $clinicId)
    {
        return $this->manager->getRepository(SpecialistWorkHours::class)->findBy([
            'specialistId' => $specId,
            'clinicId' => $clinicId,
        ]);
    }

    /**
     * @param int $specId
     * @param int $clinicId
     * @param int $day
     * @return SpecialistWorkHours[]|object[]
     */
    public function getWorkHoursByDay(int $specId, int $clinicId, int $day)
    {
        return $this->manager->getRepository(SpecialistWorkHours::class)->findBy([
            'specialistId' => $specId,
            'clinicId' => $clinicId,
            'day' => $day,
        ]);
    }

    /**
     * @param int $specId
     * @param int $clinicId
     * @param int $day
     * @param string|null $startOrEndOfDay
     * @return string
     */
    public function getWorkHoursTime(int $specId, int $clinicId, int $day, string $startOrEndOfDay = null)
    {
        $spec = $this->manager->getRepository(SpecialistWorkHours::class)->findBy([
            'specialistId' => $specId,
            'clinicId' => $clinicId,
            'day' => $day,
        ]);
        if (sizeof($spec) == 0) {
            return null;
        }
        if ($startOrEndOfDay == 'start') {
            return $spec[0]->getStartTime()->format('H:i');
        } else {
            return $spec[0]->getEndTime()->format('H:i');
        }
    }

    /**
     * @param $dayCount
     * @return string
     * @throws Exception
     */
    public function getDateFromDayNumber($dayCount): string
    {
        $date = new DateTime();

        return $date->modify('this week +' . ($dayCount - 1) . ' days')->format('Y-m-d');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getSpecialistVisits(int $id)
    {
        return $this->manager->getRepository(UserVisit::class)->findSpecialistVisits($id);
    }

    public function removeSpecialistWorkHours(User $specialist, User $clinic)
    {
        $workHours = $this->getWorkHours($specialist->getId(), $clinic->getId());
        foreach ($workHours as $workHour) {
            $this->manager->remove($workHour);
        }
        //$this->manager->flush();
    }
}
