<?php 
/**
 *  The RPC base class.
 */

namespace Stellite\Rpc;


class Base{
	
    public $url;
    private $username;
    private $password;
  
    public function __construct($host = 'http://127.0.0.1:20189', $username = null, $password = null){
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

    protected function _postRequest($method, $params = [],$asArray = true){

        $rpc = [
            "jsonrpc"=>"2.0",
            "id"=>"stellitephp",
            "method"=>$method
        ];
        if($params){
            $rpc["params"]=$params;
        }

        $context = ['http' =>[
            'method' => 'POST',
            'header' => [
                "Content-Type: type=application/json\r\n",
            ],
            'content' => json_encode($rpc)
        ]];
        if($this->username && $this->password){
            $context['http']['header'][] = "Authorization: Basic " . base64_encode("$this->username:$this->password");
        }
        
        $stream = stream_context_create($context);
        $response = file_get_contents($this->url.'/json_rpc', false, $stream);
        return json_decode($response, $asArray);
    }
    
    protected function _getRequest($uri,$asArray = true){
        $_url = $this->url . $uri;
        $context = ['http' =>[
            'method' => 'GET',
            'header' => [
                "Content-Type: type=application/json\r\n",
            ]
        ]];

        if($this->username && $this->password){
            $context['http']['header'][] = "Authorization: Basic " . base64_encode("$this->username:$this->password");
        }
        
        $stream = stream_context_create($context);
        $response = file_get_contents($_url,false,$stream);
        return json_decode($response, $asArray);
    }


}
