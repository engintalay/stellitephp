<?php

/**
 * 
 *  Stellite/Rpc/Daemon
 *  The daemon class. A class for making calls to stellited using PHP
 *  https://github.com/stellitecoin/stellitephp
 * 
 * @author     ahmyi <cryptoamity@gmail.com> (https://github.com/ahmyi)
 * @copyright  2018
 * @license    MIT
 * 
 * Eg. 
 *  $daemon = new \Stellite\Rpc\Daemon($url,$username,$password);
 *  $daemon->getBlockCount();
 * 
 */

namespace Stellite\Rpc;

use Stellite\Error\MissingParamsException;
use Stellite\Error\InvalidParamTypeException;

class Daemon extends Base{
    
	/**
   * getblockcount
   * Look up how many blocks are in the longest chain known to the node.
   *
   * @param  boolean; To parse output as array or object
   *
   *    
   * @return object | array
   * count - unsigned int; Number of blocks in longest chain seen by the node.
   * status - string; General RPC error code. "OK" means everything looks good.
   *
   */
    public function getBlockCount(){
        return $this->_postRequest('getblockcount',[]);
    }
    
    
	/**
   *
   * onGetBlockHash
   * Look up a block's hash by its height
   *
   * @param  number | array $height   Height of block to look up
   *
   * @return false | object | array
   *	{
   *		"id": "0",
   *		"jsonrpc": "2.0",
   *		"result": "e22cf75f39ae720e8b71b3d120a5ac03f0db50bba6379e2850975b4859190bc6"
   *	} 
   * result - string; Hash string of height
   * 
   */
   
  public function onGetBlockHash($height){
  	if(is_array($height)){
  		if(!isset($height['height'])){
  			throw new MissingParamsException("height");
  		}
  		
  		$height = $height['height'];
  		
  	}
  	
  	if(!is_integer($height)){
  		throw new InvalidParamTypeException([
  			'height'=>'integer'	
  		]);
  	}
  	
    return $this->_postRequest('on_getblockhash',compact('height'));
  }
  
  /**
   * getLastBlockHeader
   * Block header information for the most recent block is easily retrieved with this method. No inputs are needed.
   * @param none
   * @return false | object | array
   * Outputs:
   *	block_header - A structure containing block header information.
   *	block_size - unsigned int; The block size in bytes.
   *	depth - unsigned int; The number of blocks succeeding this block on the blockchain. A larger number means an older block.
   *	difficulty - unsigned int; The strength of the Monero network based on mining power.
   *	hash - string; The hash of this block.
   *	height - unsigned int; The number of blocks preceding this block on the blockchain.
   *	major_version - unsigned int; The major version of the monero protocol at this block height.
   *	minor_version - unsigned int; The minor version of the monero protocol at this block height.
   *	nonce - unsigned int; a cryptographic random one-time number used in mining a Monero block.
   *	num_txes - unsigned int; Number of transactions in the block, not counting the coinbase tx.
   *	orphan_status - boolean; Usually false. If true, this block is not part of the longest chain.
   *	prev_hash - string; The hash of the block immediately preceding this block in the chain.
   *	reward - unsigned int; The amount of new atomic units generated in this block and rewarded to the miner. Note: 1 XMR = 1e12 atomic units.
   *	timestamp - unsigned int; The unix time at which the block was recorded into the blockchain.
   *	status - string; General RPC error code. "OK" means everything looks good.
   *	untrusted - boolean; States if the result is obtained using the bootstrap mode, and is therefore not trusted (true), or when the daemon is fully synced (false).
   * 
   */
   
   public function getLastBlockHeader(){
		$this->_postRequest('getblockheader',[]);
   }
   
   /**
   *	getBlockHeaderByHash
   *	Look up a block header from a block hash
   *
   *	@param  string  $hash  The block's SHA256 hash
   *
   *	@return false | object | array
   *	
   *	{
   *		"block_header": {
   *			"depth": 78376,
   *			"difficulty": 815625611,
   *			"hash": "e22cf75f39ae720e8b71b3d120a5ac03f0db50bba6379e2850975b4859190bc6",
   *			"height": 912345,
   *			"major_version": 1,
   *			"minor_version": 2,
   *			"nonce": 1646,
   *			"orphan_status": false,
   *			"prev_hash": "b61c58b2e0be53fad5ef9d9731a55e8a81d972b8d90ed07c04fd37ca6403ff78",
   *			"reward": 7388968946286,
   *			"timestamp": 1452793716
   *		},
   *   		"status": "OK"
   *	}
   * 
   * Outputs:
   *	block_header - A structure containing block header information. See get_last_block_header.
   *	status - string; General RPC error code. "OK" means everything looks good.
   *	untrusted - boolean; States if the result is obtained using the bootstrap mode, and is therefore not trusted (true), or when the daemon is fully synced (false).
   */
  public function getBlockHeaderByHash($hash){
  	
  	if(is_array($hash)){
  		if(!isset($hash['hash'])){
			throw new MissingParamsException("hash");
  		}
  		$hash = $hash['hash'];
  	}
  	
    return $this->_postRequest('getblockheaderbyhash', compact('hash'));
  }
  
  
  /**
   * getBlockHeaderByHeight
   * Look up a block header by height
   *
   * @param  int	$height  Height of block
   *
   * @return object  Example: 
   *	{
   *		"block_header": {
   *    		"depth": 78376,
   *    		"difficulty": 815625611,
   *    		"hash": "e22cf75f39ae720e8b71b3d120a5ac03f0db50bba6379e2850975b4859190bc6",
   *    		"height": 912345,
   *    		"major_version": 1,
   *    		"minor_version": 2,
   *    		"nonce": 1646,
   *    		"orphan_status": false,
   *    		"prev_hash": "b61c58b2e0be53fad5ef9d9731a55e8a81d972b8d90ed07c04fd37ca6403ff78",
   *    		"reward": 7388968946286,
   *    		"timestamp": 1452793716
   *		},
   *		"status": "OK"
   *	}
   * 
   * Outputs:
   *	block_header - A structure containing block header information. See get_last_block_header.
   *	status - string; General RPC error code. "OK" means everything looks good.
   *	untrusted - boolean; States if the result is obtained using the bootstrap mode, and is therefore not trusted (true), or when the daemon is fully synced (false).
   */
   
  public function getBlockHeaderByHeight($height){

  	if(is_array($height)){
  		if(!isset($height['height'])){
  			throw new MissingParamsException("height");
  		}
  		
  		$height = $height['height'];
  		
  	}
  	
  	if(!is_integer($height)){
  		throw new InvalidParamTypeException([
  			'height'=>'integer'	
  		]);
  	}
  	
    return $this->_postRequest('getblockheaderbyheight', compact('height'));
  }
  
  /**
   * getBlockHeadersRange
   * Similar to get_block_header_by_height above, but for a range of blocks. This method includes a starting block height and an ending block height as parameters to retrieve basic information about the range of blocks.
   * @params 
   * start_height - unsigned int; The starting block's height.
   * end_height - unsigned int; The ending block's height.
   * 
   * @return false | object | array
   *	{
   *		"result": {
   *			"headers": [{
   *				"block_size": 301413,
   *				"depth": 16085,
   *				"difficulty": 134636057921,
   *				"hash": "86d1d20a40cefcf3dd410ff6967e0491613b77bf73ea8f1bf2e335cf9cf7d57a",
   *				"height": 1545999,
   *				"major_version": 6,
   *				"minor_version": 6,
   *				"nonce": 3246403956,
   *				"num_txes": 20,
   *				"orphan_status": false,
   *				"prev_hash": "0ef6e948f77b8f8806621003f5de24b1bcbea150bc0e376835aea099674a5db5",
   *				"reward": 5025593029981,
   *				"timestamp": 1523002893
   *			},{
   *				"block_size": 13322,
   *				"depth": 16084,
   *				"difficulty": 134716086238,
   *				"hash": "b408bf4cfcd7de13e7e370c84b8314c85b24f0ba4093ca1d6eeb30b35e34e91a",
   *				"height": 1546000,
   *				"major_version": 7,
   *				"minor_version": 7,
   *				"nonce": 3737164176,
   *				"num_txes": 1,
   *				"orphan_status": false,
   *				"prev_hash": "86d1d20a40cefcf3dd410ff6967e0491613b77bf73ea8f1bf2e335cf9cf7d57a",
   *				"reward": 4851952181070,
   *				"timestamp": 1523002931
   *			}],
   *			"status": "OK",
   *			"untrusted": false
   *		}
   *	}
   * 
   * Outputs:
   *	headers - array of block_header (a structure containing block header information. See get_last_block_header).
   *	status - string; General RPC error code. "OK" means everything looks good.
   *	untrusted - boolean; States if the result is obtained using the bootstrap mode, and is therefore not trusted (true), or when the daemon is fully synced (false).
   * 
   */
   
   public function getBlockHeadersRange($start_height,$end_height){
		
	  	if(is_array($start_height)){
	  		if(!isset($start_height['start_height']) || !isset($start_height['end_height'])){
	  			throw new MissingParamsException(["start_height","end_height"]);
	  		}
	  		
	  		$end_height = $start_height['end_height'];
			$start_height = $start_height['start_height'];
			
	  	}
   		
   		if(!is_integer($end_height) || !is_integer($start_height)){
	  		throw new InvalidParamTypeException([
	  			'start_height'=>'integer',
	  			'end_height'=>'integer'	
			]);
	  	}
  		
		return $this->_postRequest('getblockheadersrange', compact('start_height','end_height'));
   }
   
   /**
   * getConnections
   * Look up incoming and outgoing connections to your node
   *
   * @param  none
   *
   * @return object  Example: {
   *   "connections": [{
   *     "avg_download": 0,
   *     "avg_upload": 0,
   *     "current_download": 0,
   *     "current_upload": 0,
   *     "incoming": false,
   *     "ip": "76.173.170.133",
   *     "live_time": 1865,
   *     "local_ip": false,
   *     "localhost": false,
   *     "peer_id": "3bfe29d6b1aa7c4c",
   *     "port": "18080",
   *     "recv_count": 116396,
   *     "recv_idle_time": 23,
   *     "send_count": 176893,
   *     "send_idle_time": 1457726610,
   *     "state": "state_normal"
   *   },{
   *   ..
   *   }],
   *   "status": "OK"
   * }
   *
   */
  public function getConnections(){
    return $this->_postRequest('get_connections');
  }
  
  /**
   * getInfo
   * Look up general information about the state of your node and the network
   *
   * @param  none
   *
   * @return object  Example: {
   *   "alt_blocks_count": 5,
   *   "difficulty": 972165250,
   *   "grey_peerlist_size": 2280,
   *   "height": 993145,
   *   "incoming_connections_count": 0,
   *   "outgoing_connections_count": 8,
   *   "status": "OK",
   *   "target": 60,
   *   "target_height": 993137,
   *   "testnet": false,
   *   "top_block_hash": "",
   *   "tx_count": 564287,
   *   "tx_pool_size": 45,
   *   "white_peerlist_size": 529
   * }
   *
   */
  public function getInfo(){
    return $this->_postRequest('get_info');
  }

}
