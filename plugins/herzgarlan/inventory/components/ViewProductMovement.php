<?php namespace HerzGarlan\Inventory\Components;

use Auth;
use Cms\Classes\ComponentBase;
use HerzGarlan\Inventory\Models\Product as Product;
use HerzGarlan\Inventory\Models\ProductMovement as ProductMovement;
use Backend\Models\User as BackendUser;
use Lang;

class ViewProductMovement extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'View Product Movement component',
            'description' => 'Corporate customers view details of their product movement'
        ];
    }

    public function productmovements()
    {
        $product_id = $this->param('product_id');
        $product = Product::where('id', $product_id)->get();
        $productmovements = ProductMovement::where('product_id', '=', $product_id)->paginate(15);
        $backend_user = BackendUser::where('id', $productmovements[0]['backend_user_id'])->get();
        foreach ($productmovements as $key => $movement)
        {
            $productmovements[$key]['backend_user_name'] = $backend_user[0]['first_name'];
            $productmovements[$key]['product_name'] = $product[0]['name'];
        }

        return $productmovements;
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