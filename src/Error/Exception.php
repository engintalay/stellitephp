<?php

namespace Stellite\Error;

// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
use Exception as BaseException;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Run;

class Exception extends BaseException{
	
	public function onMessage($message){
		return $message;	
	}
	
	public function __construct($message = "" , $code = 0 , $previous = NULL){

		$run     = new Run();
		$handler = new PrettyPageHandler();
		
		$handler->setApplicationPaths([__DIR__]);
		
		$handler->addDataTableCallback('Details', function(\Whoops\Exception\Inspector $inspector) {
			
		    $data = array();
		    $exception = $inspector->getException();
		    if ($exception instanceof SomeSpecificException) {
		        $data['Important exception data'] = $exception->getSomeSpecificData();
		    }
		    $data['Exception class'] = get_class($exception);
		    
		    $m = $exception->getMessage();
		    
		    $data['Exception message'] = $m;
		    return $data;
		});
		
		if (\Whoops\Util\Misc::isAjaxRequest() || (isset($_SERVER['HTTP_ACCEPT'])&&strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)){
			$jsonHandler = new JsonResponseHandler();
    		$jsonHandler->setJsonApi(true);
    		$run->pushHandler($jsonHandler);	    
		}
		
		$run->pushHandler($handler);
		
		$run->register();
		parent::__construct($this->onMessage($message),$code,$previous);
	}
}

