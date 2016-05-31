<?php namespace HerzGarlan\Config\Models;

use Model;
use Flash;
use Input;
use ValidationException;
use HerzGarlan\Config\Classes\DatesHelper;
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
    'date_start' => 'required|after:now',
    'date_end' => 'required|after:now',
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $dates = ['date_start','date_end'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_config_blocked_dates';

    public function beforeValidate()
    {
        $inputs = Input::get('BlockedDates');

        if(!empty($inputs['date_start']) AND !empty($inputs['date_end']))
        {
            // check the selected date against Blocked Dates config
            $isValidDateRange = DatesHelper::isValidDateRange($this->date_start, $this->date_end);
           if(!$isValidDateRange){
                throw new ValidationException(['date_end' => 'End date must be greater than the start date.']);
            }
        }
    }

    public function afterCreate()
    {
        Flash::success('Blocked dates has been created successfully.');
    }

    public function afterSave()
    {
        Flash::success('Blocked dates has been updated successfully.');
    }

}