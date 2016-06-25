<?php namespace HerzGarlan\Config\Models;

use Model;
use Flash;
use DB;
use RainLab\User\Models\User;

/**
 * Customer Model
 */
class Customer extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_config_customers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    public $belongsTo = [
        'customer' => ['RainLab\User\Models\User'],
        'user' => ['RainLab\User\Models\User']
    ];

    public $belongsToMany = [
        'rates' => [
            'HerzGarlan\Config\Models\Rate',
            'table' => 'herzgarlan_config_customers_rates',
            'pivot' => ['value'],
            'pivotModel' => 'HerzGarlan\Config\Models\CustomerRatePivot'
        ],
    ];

    public function getUserOptions()
    {
        $customerWithRates = DB::table('herzgarlan_config_customers')->lists('user_id');
        return User::whereNotIn('id', $customerWithRates)->orderBy('company','asc')->lists('company','id');
    }

    public function afterCreate()
    {
        Flash::success('Customer rates has been created successfully.');
    }

    public function afterSave()
    {
        Flash::success('Customer rates has been updated successfully.');
    }


}