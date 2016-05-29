<?php namespace HerzGarlan\Config\Models;

use Model;
use BackendAuth;

/**
 * Model
 */
class Rate extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];

    public $belongsTo = [
        'backend_user' => 'Backend\Models\User'
    ];

    public $belongsToMany = [
        'delivery_order' => ['HerzGarlan\Jobs\Models\DeliveryOrder', 'table' => 'herzgarlan_jobs_delivery_order', 'delete' => true]
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_config_rates';

    public function beforeValidate()
    {
        $rate = Rate::find(1);
        $backend_user = BackendAuth::getUser();
        $rate->backend_user_id = $backend_user->id;
    }
}