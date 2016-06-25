<?php namespace HerzGarlan\Config\Models;

use October\Rain\Database\Pivot;
use Flash;

/**
 * Pivot Model
 */
class CustomerRatePivot extends Pivot
{
	public function beforeSave()
	{
		$pattern = "/^([1-9][0-9]*|0)(\.[0-9]{2})?$/";

		if(empty($this->value)){
			Flash::error('The Rate price is required');
        	return false;
		}

		if(! preg_match($pattern, $this->value)){
			Flash::error('The Rate price format is invalid');
        	return false;
		}

		
	}

}