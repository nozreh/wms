<?php namespace HerzGarlan\Inventory;

use System\Classes\PluginBase;
use Validator;
use Event;
use Flash;
use HerzGarlan\Inventory\Models\Product as ProductModel;
use HerzGarlan\Inventory\Models\ProductMovement;

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

		// Create a movement log of product
		ProductModel::extend(function($model) {
		    $model->bindEvent('model.afterSave', function() use ($model) {
		    	$count = ProductMovement::where('product_id', $model->id)->count();
		    	$reason = $count > 0 ? 'Product Update' : 'Product Create';
		    	ProductMovement::add($model, $reason);
		    });
		});
	}

	public function beforeValidate($model)
	{
		$sessionKey = uniqid('session_key', true);
		$product = Product::find(1);

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
