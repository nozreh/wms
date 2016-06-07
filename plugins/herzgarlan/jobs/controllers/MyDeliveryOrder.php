<?php namespace HerzGarlan\Jobs\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class MyDeliveryOrder extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Jobs', 'jobs', 'my_delivery_order');
    }

    public function listExtendColumns($list)
    {
        $list->addColumns([
        	'rates' => [
                'label' => 'herzgarlan.jobs::lang.rate',
                'type'	=> 'partial',
                'sortable' => 'true',
                'path' => '~/plugins/herzgarlan/jobs/models/deliveryorder/field_rates.htm'
            ]
        ]);
    }


    public function listExtendQuery($query)
    {
        $backend_user = BackendAuth::getUser();
        $query->where('backend_user_id',  $backend_user->id);
    }

}