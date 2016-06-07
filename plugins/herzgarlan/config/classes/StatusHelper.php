<?php namespace HerzGarlan\Config\Classes;

use October\Rain\Exception\ApplicationException;

class StatusHelper
{
    /*
    * @var timestamp
    * @return bool
    */

    protected $statusList = [
                0 => 'Pending',
                1 => 'Delivered',
                2 => 'Undelivered'
    ];


    public static function getStatus($status)
    {
        if( !empty($status) ){

            if(in_array($status, $statusList)){
                return $statusList[$status];
            }
            else
                throw new ApplicationException('Status parameter is invalid!');
        }
        else
        {
            return $this->statusList;
        }   
    }

}