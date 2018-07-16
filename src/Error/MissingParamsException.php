<?php

namespace Stellite\Error;

use Stellite\Error\Exception as BaseExcception;

class MissingParamsException extends BaseException{

	public function onMessage($params = '')	{
		if(is_array($params)){
			$params = implode(', ', $params);
		}
		return "Missing paramters. Require parameters: {$params}.";
	}
}