<?php namespace HerzGarlan\Config\Models;

use Model;

/**
 * Model
 */
class Timeslot extends Model
{
    use \October\Rain\Database\Traits\Validation;
    protected $jsonable = ['timeslot'];
    /*
     * Validation
     */
    public $rules = [
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_config_timeslots';
}