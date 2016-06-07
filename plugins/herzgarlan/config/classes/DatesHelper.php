<?php namespace HerzGarlan\Config\Classes;

use October\Rain\Exception\ApplicationException;
use HerzGarlan\Config\Models\BlockedDates;
use Carbon\Carbon;

class DatesHelper
{
    /*
    * @var timestamp
    * @return bool
    */
    public static function isValidDateRange($date_start, $date_end)
    {
        if( !empty($date_start) AND !empty($date_end) ){
            $start = Carbon::parse($date_start)->toDateTimeString();
            $start = strtotime($start);
            $end = Carbon::parse($date_end)->toDateTimeString();
            $end = strtotime($end);
           
            if($start >= $end)
            {
                return false;
            }

            return true;
        }
        else
        {
            throw new ApplicationException('Date parameter is missing!');
        }   
    }

}