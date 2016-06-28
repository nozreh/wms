<?php namespace HerzGarlan\Jobs;

use System\Classes\PluginBase;
use HerzGarlan\Jobs\Models\DeliveryOrder;
use HerzGarlan\Jobs\Models\MyDeliveryOrder;
use HerzGarlan\Jobs\Models\DeliveryOrderLog;

class Plugin extends PluginBase
{

	public function boot(){

		// Create a delivery order log
		DeliveryOrder::extend(function($model) {
		    $model->bindEvent('model.afterSave', function() use ($model) {
		    	$status = $model->status;
		    	$remarks = '';
		    	DeliveryOrderLog::add($model, $status, $remarks);
		    });
		});

		// Create a my delivery order log
		MyDeliveryOrder::extend(function($model) {
		    $model->bindEvent('model.afterSave', function() use ($model) {
		    	$status = $model->status;
		    	$remarks = '';
		    	DeliveryOrderLog::add($model, $status, $remarks);
		    });
		});
	}



    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
