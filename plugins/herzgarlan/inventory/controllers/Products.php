<?php namespace HerzGarlan\Inventory\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Products extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';


    public $requiredPermissions = [
        'manage_products' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Inventory', 'inventory', 'products');
    }

    public function getRandomCode(){
        return str_random(10);
    }

}