<?php namespace HerzGarlan\Config\Models;

use Model;

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

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_config_rates';
}