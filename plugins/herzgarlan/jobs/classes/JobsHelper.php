<?php namespace HerzGarlan\Jobs\Classes;

use October\Rain\Exception\ApplicationException;
use HerzGarlan\Jobs\Models\DeliveryOrder;
use HerzGarlan\Config\Models\BlockedDates;
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

}