<?php 
/**
 *  The RPC base class.
 */

namespace Stellite\Rpc;
use Stellite\Error\Exception;

class Base{
	protected $_interface = [];
	public $url;
    private $username;
    private $password;
    public $ID = "stellitephp";
    public $isArray = false;
  
  	public function __construct(string $host = 'http://127.0.0.1:20189',string $username = null,string $password = null){
        if (is_array($host)) { 
            $params = $host;
            if (issset($params['url'])) {
                $url = $params['url'];
            } else {
                $url = 'http://127.0.0.1:20189';
            }
            if (isset($params['user'])) {
              $user = $params['user'];
            }
            if (isset($params['password'])) {
              $password = $params['password'];
            }
        }else{
        	$url = $host;
        }
        $this->username= $username;
        $this->password = $password;
        $this->url = $url;
    }

    private function _build_post_context($postdata) {
            $context = [
                    'http' =>[
                            'method' => 'POST',
                            'header' => [
                                    "Content-Type: application/json"
                            ],
                            'content' => json_encode($postdata)
                    ]
            ];
            if($this->username && $this->password){
                $context['http']['header'][] = "Authorization: Basic " . base64_encode("$this->username:$this->password");
            }
            return stream_context_create($context);
    }


    protected function _request(string $method,$params = null,bool $isRpcJson = true){
            $rpc = ($isRpcJson)?"json_rpc":$method;
            $url = $this->url . '/'.$rpc;
            $context = null;
            
            if($isRpcJson){
                $jsonRpcData = [
                    "jsonrpc"=>"2.0",
                     "id"=>$this->ID,
                     "method"=>$method,
                     "params"=>$params
                ];
                
                // var_dump($jsonRpcData);

                $context = $this->_build_post_context($jsonRpcData);    
            }else if($params){
                $context = $this->_build_post_context($params);    
            }

            $response = file_get_contents($url, false, $context);
            $output = json_decode($response, $this->isArray === false);
            // echo "<pre>";
            // var_dump($output);
            if(isset($output['error'])){
                throw new \Exception($output['error']['message']);
            }
            if(isset($output['result']['error'])){
                throw new \Exception($output['result']['error']['message']);
            }

            if(isset($output['result'])){
                return $output['result'];
            }
                
            if(isset($output->error)){
                throw new \Exception($output->error->message);
            }

            if(isset($output->result->error)){
                throw new \Exception($output->result->error->message);
            }

            if(isset($output->result)){
                return $output->result; 
            }
            
            return $output;
    }

    public function __call($name, $arguments){
        if(isset($this->_interface[$name])){
          $options = isset($arguments[0])?$arguments[0]:[];

          $interfaces = $this->_interface[$name];
          
          if(isset($interfaces['params'])){
            if($interfaces['params'] === false){
                $options = [];
            }else{
                if(isset($interfaces['params']['OR'])){
                    $exists = false;
                    foreach($interfaces['params']['OR'] as $or_key){

                        if(isset($options[$or_key])){
                           $exists = true;
                           break;
                        }   
                    }
                    if(!$exists){
                        throw new \Exception("Invalid parameters for $name pick either these keys: ".implode(",",$interfaces['params']['OR']));
                    }
                    unset($interfaces['params']['OR']);
                }

                if(isset($interfaces['params'])){
                    foreach($interfaces['params'] as $key){
                        if(!isset($options[$key])){
                            throw new \Exception("Invalid parameters for $name required keys: ".implode(",",$interfaces['params']));
                        }
                    }
                }
            }
          }

          return $this->_request($name,$options,isset($interfaces['isRpc']) && $interfaces['isRpc'] === true);
        }
        if(method_exists($this, $name)){
          return call_user_func_array([$this, $name], $arguments);
        }

        throw new \Exception("Invalid rpc calls");
      }


}
