<?php namespace HerzGarlan\Config\Models;

use Model;
use Flash;
/**
 * Model
 */
class BlockedDates extends Model
{
    use \October\Rain\Database\Traits\Validation;

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
    public $table = 'herzgarlan_config_blocked_dates';

    public function afterCreate()
    {
        Flash::success('Blocked dates has been created successfully.');
    }

    public function afterSave()
    {
        Flash::success('Blocked dates has been updated successfully.');
    }

}