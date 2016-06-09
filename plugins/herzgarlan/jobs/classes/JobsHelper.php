<?php namespace HerzGarlan\Jobs\Classes;

use October\Rain\Exception\ApplicationException;
use HerzGarlan\Jobs\Models\DeliveryOrder;
use HerzGarlan\Config\Models\BlockedDates;
use HerzGarlan\Config\Models\Timeslot;
use Carbon\Carbon;

class JobsHelper
{
    /*
    * @var timestamp
    * @return bool
    */
    public static function isBlockedDate($deliveryDate)
    {
        if( !empty($deliveryDate) ){
            $blockdDates = BlockedDates::get()->all();
            // check all the stored blocked dates
            foreach ($blockdDates as $date) {
                $order_date = Carbon::parse($deliveryDate)->toDateTimeString();
                $order_date = strtotime($order_date);
                $end = strtotime($date['date_end']);
                $start = strtotime($date['date_start']);
               
                if( ($order_date >= $start) AND ($order_date <= $end) )
                {
                    return true;
                }
            }

            return false;
        }
        else
        {
            throw new ApplicationException('Date parameter is missing!');
        }   
    }

    public static function getAvailableTimeslots($deliveryDate)
    {
        if( !empty($deliveryDate) ){
            $availableDates = Timeslot::get()->all();
            $order_date = Carbon::parse($deliveryDate);
            foreach ($availableDates as $key => $slot) {
                if($slot['day'] == $order_date->dayOfWeek)
                {
                    return $availableDates[$key]; // return all slots for that day of the week
                    break;
                }
            }
        }
        else
        {
            throw new ApplicationException('Date parameter is missing!');
        }   
    }

    public static function getCapacityByTimeslot($deliveryDate, $timeslot)
    {
        if( !empty($deliveryDate) AND  !empty($timeslot) )
        {
            $capacityTaken = DeliveryOrder::where(['order_date' => $deliveryDate,'timeslot'=>$timeslot])->get();
            return $capacityTaken;       
        }
        else
        {
            throw new ApplicationException('JobsHelper::getCapacityByTimeslot(), Date and Timeslot parameters are required!');
        }   
    }

}