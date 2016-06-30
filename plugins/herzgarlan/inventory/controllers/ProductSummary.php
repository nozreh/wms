<?php namespace HerzGarlan\Inventory\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use HerzGarlan\Inventory\Models\ProductMovement;
use BackendAuth;
use Rainlab\User\Models\User;
use Flash;

class ProductSummary extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController',
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'manage_own_products' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Inventory', 'productsummary', 'productsummary');
    }

    public function listExtendQuery($query)
    {
        $backend_user = BackendAuth::getUser();
        $user = User::where(['backend_user_id' => $backend_user->id ])->first();
        // make sure admin was assigned to the user
        if( $user )
        {
            $query->where(['customer_id' => $user->id])->orderBy('created_at','asc');
        }
        else
        {
            Flash::error('This Admin Account does not have a Product or User account.');
            $query->where('id', 0);
        }
        
    }
}