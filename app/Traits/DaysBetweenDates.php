<?php

namespace App\Traits;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

trait DaysBetweenDates
{
    public function dates($start, $end)
    {
        $format = 'Y-m-d';

        $array = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

    public function days($starting, $ending)
    {
        $dates = [];
        foreach ($this->dates($starting, $ending) as $date) {
            $dates[] = Carbon::parse($date)->format('d M');
            // $dates[] = Carbon::parse($date)->toFormattedDateString();
        }
        return $dates;
    }
}
