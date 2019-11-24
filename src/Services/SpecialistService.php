<?php


namespace App\Services;

use App\Entity\ClinicSpecialists;
use App\Entity\SpecialistWorkHours;
use App\Entity\User;
use Carbon\CarbonInterval;
use DatePeriod;
use Doctrine\ORM\EntityManagerInterface;

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
     * @param $workHours
     * @return array
     */
    public function getSpecialistHoursFormatted($workHours): array
    {
        $dateArr = [];
        foreach ($workHours as $workHour) {
            $period = new DatePeriod(
                $workHour->getStartTime(),
                CarbonInterval::minutes(30),
                $workHour->getEndTime()->modify('+1 second')
            );
            $arr = [];
            foreach ($period as $d) {
                $arr[] = $d->format('H:i:s');
            }
            $dateArr[] = array(
                'clinicId' => $workHour->getClinicId(),
                array(
                    'day' => $workHour->getDay(),
                    'hours' => $arr
                )
            );
        }
        return $dateArr;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSpecialist($id)
    {
        return $this->manager->getRepository(User::class)->findByIdAndRole($id, 2);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getClinic($id)
    {
        return $this->manager->getRepository(User::class)->findByIdAndRole($id, 3);
    }

    /**
     * @param $id
     * @return ClinicSpecialists[]|object[]
     */
    public function getSpecialistClinics($id)
    {
        return $this->manager->getRepository(ClinicSpecialists::class)->findBy(['specialistId' => $id]);
    }

    /**
     * @param $specialist
     * @return SpecialistWorkHours[]|array|object[]
     */
    public function getSpecialistWorkHours($specialist)
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

    public function getWorkHoursByDay(int $specId, int $clinicId, int $day)
    {
        return $this->manager->getRepository(SpecialistWorkHours::class)->findBy([
            'specialistId' => $specId,
            'clinicId' => $clinicId,
            'day' => $day
        ]);
    }

    public function getWorkHoursTime(int $specId, int $clinicId, int $day, string $startOrEndOfDay = null)
    {
        $spec = $this->manager->getRepository(SpecialistWorkHours::class)->findBy([
            'specialistId' => $specId,
            'clinicId' => $clinicId,
            'day' => $day,
        ]);
        try {
            if ($startOrEndOfDay == 'start') {
                return $spec[0]->getStartTime()->format('H:i');
            } else {
                return $spec[0]->getEndTime()->format('H:i');
            }

        } catch (\Exception $e) {
        }
    }
}
