<?php

namespace Stellite\Error;

use Stellite\Error\Exception as BaseException;


class InvalidParamTypeException extends BaseException{
	
	public function onMessage($message){
		$type = [];
		if(!in_array($message)){
			throw new Exception("Invalid format. Message should be in array");
		}
		foreach($message as $var => $type){
			$type[] = "$var : $type";
		}
		return "Invalid paramter type. Parameter should follow as: ".implode(', ',$type);
	}
}