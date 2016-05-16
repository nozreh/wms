<?php namespace HerzGarlan\Inventory\Models;

use Model;
use RainLab\User\Models\User as User;

/**
 * Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    protected $jsonable = ['loose_carton'];
    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:3,255|unique:herzgarlan_inventory_product',
        'code' => 'required|between:3,255',
        'customer' => 'required',
        'barcode' => 'required',
        'description' => 'required',
        'carton_quantity' => 'required|numeric',
        'unit_quantity' => 'required|numeric',
        'loose_carton' => 'numeric_loose_carton_qty'
    ];

    public $customMessages = [
        'numeric_loose_carton_qty' => 'Carton Quantity and Quantity per Carton fields should be all numeric.',
    ] ;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $table = 'herzgarlan_inventory_product';
    /**
     * @var array Relations
     */
    public $belongsTo = [
        'customer' => ['Rainlab\User\Models\User']
    ];

    public $hasMany = [
        'productmovement' => ['HerzGarlan\Inventory\Models\ProductMovement'],
    ];

    public $attachMany = [
        'photo' => ['System\Models\File']
    ];
}