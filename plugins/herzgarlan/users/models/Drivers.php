<?php namespace HerzGarlan\Users\Models;

use Model;

/**
 * Model
 */
class Drivers extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required',
        'email' => 'required|email|unique',
        'contact_no' => 'required' 
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_users_drivers';
}