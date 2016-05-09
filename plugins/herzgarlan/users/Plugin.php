<?php namespace HerzGarlan\Users;

use App;
use Event;
use Backend;
use BackendMenu;
use Illuminate\Foundation\AliasLoader;
use RainLab\User\Components\Account;
use RainLab\User\Models\User;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager)
        {
           $manager->addSideMenuItems('RainLab.User', 'user', [
                'users' => [
                    'label'       => 'Customers',
                    'icon'        => 'icon-user',
                    'code'        => 'users',
                    'owner'       => 'RainLab.Users',
                    'url'         => Backend::url('rainlab/user/users')
                ],
                'drivers' => [
                    'label'       => 'Drivers',
                    'icon'        => 'icon-user-secret',
                    'code'        => 'drivers',
                    'owner'       => 'RainLab.Users',
                    'url'         => Backend::url('herzgarlan/users/drivers')
                ]
            ]);
        });

    }

}
