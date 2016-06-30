<?php namespace HerzGarlan\Inventory\Models;

use Model;
use RainLab\User\Models\User as User;
use HerzGarlan\Inventory\Models\ProductMovement;

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
    public $timestamps = true;

    public $table = 'herzgarlan_inventory_product';
    /**
     * @var array Relations
     */
    public $belongsTo = [
        'customer' => ['Rainlab\User\Models\User']
    ];

    public $hasMany = [
        'productmovement' => ['HerzGarlan\Inventory\Models\ProductMovement', 'delete' => true],
        'deliveryorder' => ['HerzGarlan\Jobs\Models\DeliveryOrder', 'delete' => true]
    ];

    public $attachMany = [
        'photo' => ['System\Models\File']
    ];

    public static function getTotalBalance($product_id)
    {
        $product = Product::where('id', $product_id)->first();
        $productmovement = ProductMovement::where('product_id', $product_id)->get();
        $total_qty = 0;
        // check is there is product movement
        if( count($productmovement) > 0)
        {
            $last_index = count($productmovement) - 1;
            $main_qty =  (int)$productmovement[$last_index]['after_carton'] * (int)$productmovement[$last_index]['after_unit'];
        
            $total_qty = 0;
            $loose_carton_qty = 0;

            foreach ($productmovement[$last_index]['after_loose_carton'] as $carton) {
                $loose_carton_qty = $loose_carton_qty + ( (int)$carton['carton'] * (int)$carton['pieces'] );
            }
            $total_qty = $main_qty + $loose_carton_qty;
        }
        else // use the default product info
        {
            $main_qty =  (int)$product['carton_quantity'] * (int)$product['unit_quantity'];
        
            $total_qty = 0;
            $loose_carton_qty = 0;

            foreach ($product['loose_carton'] as $carton) {
                $loose_carton_qty = $loose_carton_qty + ( (int)$carton['carton'] * (int)$carton['pieces'] );
            }
            $total_qty = $main_qty + $loose_carton_qty;
        }

        return $total_qty;
    }

    public function getCustomerOptions()
    {
        return User::where('is_activated', '=', 1)->orderBy('company','asc')->lists('company','id');
    }

    /**
     * @var array Cache for nameList() method used in DeliverOrder model
     */
    protected static $nameList = [];
    public static function getNameList($customerId)
    {
        if (isset(self::$nameList[$customerId])) {
            return self::$nameList[$customerId];
        }
        return self::$nameList[$customerId] = self::whereCustomerId($customerId)->lists('name', 'id');
    }
    public static function formSelect($name, $customerId = null, $selectedValue = null, $options = [])
    {
        return Form::select($name, self::getNameList($customerId), $selectedValue, $options);
    }
}