<?php namespace HerzGarlan\Config\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class BlockedDates extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'herzgarlan.config.manage_blocked_dates' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HerzGarlan.Config', 'config', 'blocked_dates');
    }
}