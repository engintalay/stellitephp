<?php 

namespace Stellite\Rpc;


class Base{
    public $url;
    private $username;
    private $password;
  
    public function __construct($url = 'http://127.0.0.1:20189', $username = null, $password = null){
        if (is_array($host)) { // Parameters passed in as object/dictionary
            $params = $url;
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
        }
        $this->username= $username;
        $this->password = $password;
        $this->url = $url;
    }

    protected function _postRequest($method, $params = [],$asJson = true){

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
            context['http']['header'][] = "Authorization: Basic " . base64_encode("$this->username:$this->password");
        }
        
        $stream = stream_context_create($context);
        $response = file_get_contents($this->url, false, $stream);
        return json_decode($response, asJson);
    };
    
    protected function _getRequest($uri,$asJson = true){
        $_url = $this->url . $uri;
        $context = ['http' =>[
            'method' => 'GET',
            'header' => [
                "Content-Type: type=application/json\r\n",
            ]
        ]];

        if($this->username && $this->password){
            context['http']['header'][] = "Authorization: Basic " . base64_encode("$this->username:$this->password");
        }
        
        $stream = stream_context_create($context);
        $response = file_get_contents($_url,false,$stream);
        return json_decode($response, asJson);
    }


}
