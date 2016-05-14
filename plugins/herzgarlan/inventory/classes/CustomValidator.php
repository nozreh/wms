<?php

class CustomValidator extends Illuminate\Validation\Validator
{

	public function validateLooseCartonQty($attribute, $value, $parameters)
	{
	    return $value == 'foo';
	}

}