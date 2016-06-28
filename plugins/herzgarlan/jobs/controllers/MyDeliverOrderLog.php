<?php namespace HerzGarlan\Jobs\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class MyDeliverOrderLog extends Controller
{
    public $implement = ['Backend\Behaviors\ListController'];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'manage_own_jobs' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Jobs', 'my_delivery_order_log', 'my_delivery_order_log');
    }

    public function listExtendQuery($query)
    {
        $backend_user = BackendAuth::getUser();
        $query->where('backend_user_id',  $backend_user->id);
    }
}