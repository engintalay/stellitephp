<?php

/**
 *  The daemon class. All daemon actions called here
 *   Eg. 
 *  $daemon = new \Stellite\Rpc\Daemon($url,$username,$password);
 *  $daemon->getBlockCount();
 */

namespace Stellite\Rpc;

class Daemon{
    
  /**
   * getblockcount
   * Look up how many blocks are in the longest chain known to the node.
   * Alias: getblockcount.
   *
   * @param  none
   *
   *    
   * @return object | array
   * count - unsigned int; Number of blocks in longest chain seen by the node.
   * status - string; General RPC error code. "OK" means everything looks good.
   *
   */
    public function getBlockCount(){
        return $this->_postRequest('getblockcount');
    }

}
