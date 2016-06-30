<?php namespace HerzGarlan\Inventory\Models;

use Model;
use BackendAuth;
use Carbon\Carbon;
use HerzGarlan\Inventory\Models\Product;

/**
 * Model
 */
class ProductMovement extends Model
{
    use \October\Rain\Database\Traits\Validation;
    protected $jsonable = ['before_loose_carton', 'after_loose_carton'];
    /*
     * Validation
     */
    public $rules = [];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_inventory_product_movement';

    public $belongsTo = [
        'product' => 'HerzGarlan\Inventory\Models\Product',
        'backend_user' => 'Backend\Models\User'
    ];

    public static function add($product, $reason)
    {
        $backend_user = BackendAuth::getUser();
        $last = ProductMovement::where('product_id', $product->id)->max('id');
        $last_movement = ProductMovement::where([
                            'product_id' => $product->id,
                            'id' => $last
                            ])->get();

        $movement = new ProductMovement();
        $movement->product_id = $product->id;
        $movement->reason = $reason;

        $carton = 0;
        $pieces = 0;

        foreach ($product->loose_carton as $key => $value) {
            $carton += $product->loose_carton[$key]['carton'];
            $pieces += $product->loose_carton[$key]['pieces'];
        }

        $movement->before_carton = $last > 0 ? $last_movement[0]->after_carton : 0;
        $movement->after_carton = $product->carton_quantity;
        $movement->before_unit = $last > 0 ? $last_movement[0]->after_unit : 0;
        $movement->after_unit = $product->unit_quantity;
        $movement->backend_user_id = $backend_user->id;
        $movement->created_at = Carbon::now();
        $movement->before_loose_carton = $last > 0 ? $last_movement[0]->after_loose_carton : array();
        $movement->after_loose_carton = $product->loose_carton;
        $movement->save();
        return $movement;
    }

    public static function getBalance($productmovement_id)
    {
        $productmovement = self::where('id', $productmovement_id)->first();
        $total_qty = 0;
        // check is there is product movement
        if( count($productmovement) > 0)
        {
            // after
            $after_qty =  (int)$productmovement['after_carton'] * (int)$productmovement['after_unit'];
            $after_total = 0;
            $after_loose_carton = 0;

            foreach ($productmovement['after_loose_carton'] as $carton) {
                $after_loose_carton = $after_loose_carton + ( (int)$carton['carton'] * (int)$carton['pieces'] );
            }
            $after_total = $after_qty + $after_loose_carton;

            //before
            $before_qty =  (int)$productmovement['before_carton'] * (int)$productmovement['before_unit'];
        
            $before_total = 0;
            $before_loose_carton = 0;

            foreach ($productmovement['before_loose_carton'] as $carton) {
                $before_loose_carton = $before_loose_carton + ( (int)$carton['carton'] * (int)$carton['pieces'] );
            }

            $before_total = $before_qty + $before_loose_carton;
        }

        return ['after_balance' => $after_total, 'before_balance' => $before_total];
    }
}