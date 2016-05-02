<?php namespace HerzGarlan\Inventory\Models;

use Model;
use RainLab\User\Models\User as User;

/**
 * Model
 */
class Products extends Model
{
    use \October\Rain\Database\Traits\Validation;
    //public $customer;
    /*
     * Validation
     */
    public $rules = [
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_inventory_products';

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'customer' => ['Rainlab\User\Models\User']
    ];
}