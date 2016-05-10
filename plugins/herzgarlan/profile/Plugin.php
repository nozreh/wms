<?php namespace HerzGarlan\Profile;

use Yaml;
use File;
use Event;
use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User as UserModel;
use RainLab\User\Controllers\Users as UsersController;
use HerzGarlan\Profile\Models\Profile as ProfileModel;

class Plugin extends PluginBase
{
    public function boot()
    {
    	UserModel::extend(function($model){
    		$model->hasOne['profile'] = ['HerzGarlan\Profile\Models\Profile'];
    		//$model->attachOne['logo'] = ['System\Models\File'];
    	});
		Event::listen('backend.list.extendColumns', function($widget) {

            if (!$widget->getController() instanceof UsersController) return;
            if (!$widget->model instanceof UserModel) return;

            $columns = __DIR__ . '/models/profile/columns.yaml';
            $config = Yaml::parse(File::get($columns));
            $widget->addColumns($config['columns']);

        });

        UsersController::extendFormFields(function($form, $model, $context){

            if (!$model instanceof UserModel) return;
            if (!$model->exists) return;

            //Make sure we have a user model object
            ProfileModel::getFromUser($model);

            $fields = __DIR__ . '/models/profile/fields.yaml';
            $config = Yaml::parse(File::get($fields));
            $form->addTabFields($config['fields']);
            $form->removeField('avatar');
            $form->addSecondaryTabFields([
                'profile[logo]' => [
                        'label' => 'herzgarlan.profile::lang.logo',
                        'mode'  => 'image',
                        'useCaption'    => 'true',
                        'imageWidth' => '260',
                        'span' => 'auto',
                        'type' => 'fileupload'
                        ]
            ]);
        });

    	Event::listen('backend.form.extendFields', function($widget) 
        {
            if (!$widget->getController() instanceof UsersController) return;
            if (!$widget->model instanceof UserModel) return;

       		$widget->removeField('avatar');
        });

    }

}
