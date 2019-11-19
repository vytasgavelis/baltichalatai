<?php


namespace App\Services;

use Carbon\CarbonInterval;
use DatePeriod;

class SpecialistService
{
    public function getSpecialistHoursFormatted($workHours): array
    {
        $dateArr = [];
        foreach ($workHours as $workHour) {
            $period = new DatePeriod($workHour->getStartTime(), CarbonInterval::minutes(30),
                $workHour->getEndTime()->modify('+1 second'));
            $arr = [];
            foreach ($period as $d) {
                $arr[] = $d->format('H:i:s');
            }
            $dateArr[] = array('day' => $workHour->getDay(), 'hours' => $arr);
        }
        return $dateArr;
    }

}