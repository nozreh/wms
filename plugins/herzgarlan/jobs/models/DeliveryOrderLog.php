<?php namespace HerzGarlan\Jobs\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;

/**
 * Model
 */
class DeliveryOrderLog extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_jobs_delivery_order_log';

     public $belongsTo = [
        'customer' => 'RainLab\User\Models\User',
        'driver' => 'HerzGarlan\Users\Models\Drivers',
        'backend_user' => 'Backend\Models\User'
    ];

    public static function add($delivery_order, $status, $remarks)
    {
        $do = new DeliveryOrderLog();
        $do->delivery_order_id = $delivery_order->id;
        $do->backend_user_id = $delivery_order->backend_user_id;
        $do->customer_id = $delivery_order->user_id;
        $do->driver_id = 0;
        $do->status = $status;
        $do->remarks = $remarks;
        $do->created_at = Carbon::now();
       
        $do->save();
        return $do;
    }
}