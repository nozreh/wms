<?php namespace HerzGarlan\Profile;

use Yaml;
use File;
use Event;
use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use Lang;

class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    public function boot()
    {
    	UserModel::extend(function($model){
    		$model->attachOne['logo'] = ['System\Models\File'];
            $model->rules = [
                'name'     => 'required|between:2,255',
                'email'    => 'required|between:6,255|email|unique:users',
                'username' => 'required|between:2,255|unique:users',
                'password' => 'required:create|between:4,255|confirmed',
                'password_confirmation' => 'required_with:password|between:4,255',
                'company' => 'required'
            ];

            $model->addFillable([
                'company',
                'contact_no',
                'registration_no',
                'mailing_addr',
                'shipping_addr',
                'logo'
            ]);
        });

        Event::listen('backend.list.extendColumns', function($widget) {

            if (!$widget->getController() instanceof UsersController) return;
            if (!$widget->model instanceof UserModel) return;
            
            $widget->removeColumn('surname');
            $widget->removeColumn('username');
            $widget->removeColumn('created_at');

            $columns = __DIR__ . '/config/profile/columns.yaml';
            $config = Yaml::parse(File::get($columns));
            $widget->addColumns($config['columns']);

        });

        UsersController::extendFormFields(function($widget){

            if (!$widget->model instanceof UserModel) return;

            //Make sure we have a user model object
            $widget->removeField('name');
            $widget->removeField('surname');
            $widget->removeField('avatar');
            $widget->removeField('email');
            $widget->removeField('password');
            $widget->removeField('password_confirmation');
            $widget->removeField('username');
            $widget->removeField('groups');

            $fields = __DIR__ . '/config/profile/fields.yaml';
            $config = Yaml::parse(File::get($fields));
            $widget->addFields($config['fields']);
            
        });


    }

    public function beforeValidate($model)
    {
        $sessionKey = uniqid('session_key', true);
        $profile = Profile::find(1);

        $fileFromPost = Input::file('logo');
        // If it exists, save it as the featured image with a deferred session key
        if ($fileFromPost) {
            $model->rules = [
                'logo'  => 'mimes:jpeg,bmp,png,gif'
            ];
            $post->logo()->create(['data' => $fileFromPost], $sessionKey);
        }
    }

}
