<?php namespace HerzGarlan\Inventory\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;
use RainLab\User\Models\User;
use HerzGarlan\Inventory\Models\Product;

class MyProductMovement extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'manage_own_products' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Inventory', 'myproductmovement', 'myproductmovement');
    }

    public function listExtendQuery($query)
    {
        $backend_user = BackendAuth::getUser();
        $user = User::where(['backend_user_id' => $backend_user->id ])->first();
        $product = Product::where([ 'customer_id' => $user->id ])->first();

        $query->where('product_id', $product->id)->orderBy('created_at','asc');
    }
}