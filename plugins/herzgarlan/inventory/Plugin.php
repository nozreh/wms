<?php namespace HerzGarlan\Inventory;

use System\Classes\PluginBase;
use Validator;
use Event;
use HerzGarlan\Inventory\Models\Products as ProductModel;

class Plugin extends PluginBase
{
    
	public function boot(){
		Validator::extend('numeric_loose_carton_qty', function($attribute, $value, $parameters) {
		    foreach ($value as $v) {
		        $validator = Validator::make(
		            $v,
		            [
		                'carton' => 'numeric',
		                'pieces' => 'numeric'
		            ]
		        );
		        if ($validator->fails())
		            return false;
		    }
		    return true;
		});

	}

	public function beforeValidate($model)
	{
		ProductMovement::add();

		$sessionKey = uniqid('session_key', true);
		$product = Products::find(1);

		$fileFromPost = Input::file('photo');
		// If it exists, save it as the featured image with a deferred session key
		if ($fileFromPost) {
			$model->rules = [
                'photo'  => 'mimes:jpeg,bmp,png,gif'
            ];
		    $post->photo()->create(['data' => $fileFromPost], $sessionKey);
		}
	}

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
