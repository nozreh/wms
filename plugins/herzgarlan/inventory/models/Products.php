<?php namespace HerzGarlan\Inventory\Models;

use Model;
use RainLab\User\Models\User as User;

/**
 * Model
 */
class Products extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    protected $jsonable = ['loose_carton'];
    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:3,255|unique:herzgarlan_inventory_products',
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
    public $timestamps = true;

    public $table = 'herzgarlan_inventory_products';
    /**
     * @var array Relations
     */
    public $belongsTo = [
        'customer' => ['Rainlab\User\Models\User']
    ];
    public $belongsToMany = [
        'product' => [
            'HerzGarlan\Inventory\Models\Products',
            'table' => 'herzgarlan_inventory_product_movement',
            'pivot' => [
                        'product_id', 
                        'before_carton_qty', 
                        'after_carton_qty', 
                        'before_carton_qty', 
                        'after_carton_qty',
                        'reason', 
                        'backend_user_id'
                    ],
            'pivotModel' => 'HerzGarlan\Inventory\Models\ProductMovementPivot'
        ],
    ];

    public $attachMany = [
        'photo' => ['System\Models\File']
    ];
}