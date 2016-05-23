<?php namespace HerzGarlan\Inventory\Components;

use Auth;
use Cms\Classes\ComponentBase;
use HerzGarlan\Inventory\Models\Product as Product;
use HerzGarlan\Inventory\Models\ProductMovement as ProductMovement;
use Lang;

class ViewProduct extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'View Product Component',
            'description' => 'Corporate customers view details of their products'
        ];
    }

    public function products()
    {
        $user = $this->user();
        $products = Product::where('customer_id', '=', $user->id)->paginate(15);

        foreach ($products as $key => $product)
        {
            $productmovement = ProductMovement::where('product_id', $product->id)->get();
            $last_index = count($productmovement) > 0 ? count($productmovement) - 1 : 0;
            $main_qty =  (int)$productmovement[$last_index]['after_carton'] * (int)$productmovement[$last_index]['after_unit'];
            $loose_carton_qty = 0;

            foreach ($productmovement[$last_index]['after_loose_carton'] as $carton) {
                $loose_carton_qty = $loose_carton_qty + ( (int)$carton['carton'] * (int)$carton['pieces'] );
            }
            $products[$key]['last_moved'] = $productmovement[$last_index]['created_at'];
            $products[$key]['total_qty'] = $main_qty + $loose_carton_qty;
        }
        
        return $products;
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * Returns the logged in user, if available
     */
    public function user()
    {
        if (!Auth::check())
            return null;

        return Auth::getUser();
    }

}