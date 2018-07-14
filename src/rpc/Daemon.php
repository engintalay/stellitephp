<?php


namespace Stellite\Rpc;

class Daemon extends Base{

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


}
