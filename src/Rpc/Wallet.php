<?php

/**
 *
 * Stellite/Rpc/Wallet
 *
 * A class for making calls to stellited-wallet-rpc using PHP
 * https://github.com/stellitecoin/stellitephp
 *
 *
 * @author     ahmyi <cryptoamity@gmail.com> (https://github.com/ahmyi)
 * @copyright  2018
 * @license    MIT
 *
 * ============================================================================
 *
 * // See example.php for more examples
 *
 * // Initialize class
 * $walletRPC = new \Stellite\Rpc\Wallet('http://127.0.0.1:8082');
 *
 * // Examples:
 * $address = $walletRPC->get_address();
 * $signed = $walletRPC->sign('The Times 03/Jan/2009 Chancellor on brink of second bailout for banks');
 *
 */
 
namespace Stellite\Rpc;

use Stellite\Error\Exception;
use Stellite\Error\MissingParamsException;
use Stellite\Error\InvalidParamTypeException;
use Stellite\Coins;


class Wallet extends Base{
	
	/**
   * store
   * Save the blockchain.
   *
   * @param  none
   *
   * @return object  
   *	{
   *		"id": "0",
   *		"jsonrpc": "2.0",
   *		"result": {  }
   *	}
   *
   */
   
	public function store(){
    	return $this->_postRequest('store', []);
	}
	
	
	/**
   *
   * getBalance
   * Look up an account's balance
   *
   * @param  number  $account_index  Index of account to look up  (optional)
   *
   * @return object  Example: {
   *   "balance": 140000000000,
   *   "unlocked_balance": 50000000000
   * }
   *
   */
	public function getBalance($account_index = 0){
		
		
		if(!is_integer($account_index)){
			throw new InvalidParamTypeException([
	  			'account_index'=>'integer'	
	  		]);
		}
		
		
		
    	return $this->_postRequest('get_balance', compact('account_index'));
	}
	
	/**
   *
   * Look up wallet address(es)
   *
   * @param  number  $account_index  Index of account to look up     (optional)
   * @param  number  $address_index  Index of subaddress to look up  (optional)
   *
   * @return object  Example: {
   *   "address": "A2XE6ArhRkVZqepY2DQ5QpW8p8P2dhDQLhPJ9scSkW6q9aYUHhrhXVvE8sjg7vHRx2HnRv53zLQH4ATSiHHrDzcSFqHpARF",
   *   "addresses": [
   *     {
   *       "address": "A2XE6ArhRkVZqepY2DQ5QpW8p8P2dhDQLhPJ9scSkW6q9aYUHhrhXVvE8sjg7vHRx2HnRv53zLQH4ATSiHHrDzcSFqHpARF",
   *       "address_index": 0,
   *       "label": "Primary account",
   *       "used": true
   *     }, {
   *       "address": "Bh3ttLbjGFnVGCeGJF1HgVh4DfCaBNpDt7PQAgsC2GFug7WKskgfbTmB6e7UupyiijiHDQPmDC7wSCo9eLoGgbAFJQaAaDS",
   *       "address_index": 1,
   *       "label": "",
   *       "used": true
   *     }
   *   ]
   * }
   *
   */
	
	public function getAddress($account_index = 0, $address_index = 0){
		
		
		if(!is_integer($account_index) || !is_integer($address_index)){
			throw new InvalidParamTypeException([
  				'account_index'=>'integer',
  				'address_index'=>'integer'
  			]);
		}
		
		
		return $this->_postRequest('get_address', compact('account_index','address_index'));
	}
	
	
	/**
   * createAddress
   * Create a new subaddress
   *
   * @param  number  $account_index  The subaddress account index
   * @param  string  $label          A label to apply to the new subaddress
   *
   * @return object  Example: {
   *   "address": "Bh3ttLbjGFnVGCeGJF1HgVh4DfCaBNpDt7PQAgsC2GFug7WKskgfbTmB6e7UupyiijiHDQPmDC7wSCo9eLoGgbAFJQaAaDS"
   *   "address_index": 1
   * }
   *
   */
   
	public function createAddress($account_index = 0, $label = '',$store = true){
		
		if(!is_integer($account_index) || !is_bool($store)){
			throw new InvalidParamTypeException([
  				'account_index'=>'integer',
  				'label'=>'string',
  				'store'=>'boolean'
  			]);
		}
		
    	$output = $this->_postRequest('create_address', compact('account_index','label'));
    	if($store){
    		$save = $this->store(); // Save wallet state after subaddress creation
    	}
    	return $output;
	}
	
	/**
   * labelAddress
   * Label a subaddress
   *
   * @param  number  The index of the subaddress to label
   * @param  string  The label to apply
   *
   * @return none
   *
   */
	
	public function labelAddress($index, $label){
    	
		if(!is_integer($index)){
			throw new InvalidParamTypeException([
  				'index'=>'integer',
  				'label'=>'string'
  			]);
			
		}
		
    	return $this->_postRequest('label_address', compact('index','label'));
	}
	
	/**
   *
   * getAccounts
   * Look up wallet accounts
   *
   * @param  none
   *
   * @return object  Example: {
   *   "subaddress_accounts": {
   *     "0": {
   *       "account_index": 0,
   *       "balance": 2808597352948771,
   *       "base_address": "A2XE6ArhRkVZqepY2DQ5QpW8p8P2dhDQLhPJ9scSkW6q9aYUHhrhXVvE8sjg7vHRx2HnRv53zLQH4ATSiHHrDzcSFqHpARF",
   *       "label": "Primary account",
   *       "tag": "",
   *       "unlocked_balance": 2717153096298162
   *     },
   *     "1": {
   *       "account_index": 1,
   *       "balance": 0,
   *       "base_address": "BcXKsfrvffKYVoNGN4HUFfaruAMRdk5DrLZDmJBnYgXrTFrXyudn81xMj7rsmU5P9dX56kRZGqSaigUxUYoaFETo9gfDKx5",
   *       "label": "Secondary account",
   *       "tag": "",
   *       "unlocked_balance": 0
   *    },
   *    "total_balance": 2808597352948771,
   *    "total_unlocked_balance": 2717153096298162
   * }
   *
   */
  public function getAccounts(){
    return $this->_postRequest('get_accounts');
  }
  
  /**
   * createAccount
   * Create a new account
   *
   * @param  string  $label  Label to apply to new account
   *
   * @return none
   *
   */
   
  public function createAccount($label = '',$store=true){
  	
  	if(!is_bool($store)){
		throw new InvalidParamTypeException([
			'label'=>'string',
  			'store'=>'boolean'	
  		]);
		
	}
	
	$output = $this->_postRequest('create_account', compact('index','label'));
	if($store){
		$this->store();
	}
    
    return $output;
  }
  
  /**
   * labelAccount
   * Label an account
   *
   * @param  number $account_index  Index of account to label
   * @param  string $label          Label to apply
   *
   * @return none
   *
   */
  public function labelAccount($account_index, $label,$store=true)
  {
  	
  	if($account_index === null|| !$label){
  		throw new MissingParamsException(["account_index",'label']);
  	}
    
  	
  	if(!is_integer($account_index) || !is_bool($store)){
		throw new InvalidParamTypeException([
  			'label'=>'string',
  			'account_index'=>'integer',
  			'store'=>'boolean'
  		]);
	}
	

    $output = $this->_postRequest('label_account', compact('account_index','label'));
	if($store){
		$this->store();
	}
    return $output;
  }
  /**
   * getAccountTags
   * Look up account tags
   *
   * @param  none
   *
   * @return object  
   * {
   *   "account_tags": {
   *     "0": {
   *       "accounts": {
   *         "0": 0,
   *         "1": 1
   *       },
   *       "label": "",
   *       "tag": "Example tag"
   *     }
   *   }
   * }
   *
   */
	public function getAccountTags(){
		return $this->_postRequest('get_account_tags',[]);
	}
	
  /**
   * tagAccounts
   * Tag accounts
   *
   * @param  array   $accounts  The indices of the accounts to tag
   * @param  string  $tag       Tag to apply
   *
   * @return none
   *
   */
  public function tagAccounts($accounts, $tag,$store = true){
  	if(!$accounts || !$tag){
  		throw new MissingParamsException(["accounts","tag"]);
  	}
  	
  	if(!is_array($accounts) ||  !is_bool($store)){
		throw new InvalidParamTypeException([
  			'accounts'=>'array',
  			'tag'=>'string',
  			'store'=>'boolean'
  		]);
	}
	
	$output = $this->_postRequest('tag_accounts',compact('accounts','tag'));
    
    if($store){
    	$this->store(); // Save wallet state after account tagging
    }
    
    return $output;
  }
  /**
   *
   * untagAccounts
   * Untag accounts
   *
   * @param  array   $accounts  The indices of the accounts to untag
   *
   * @return none
   *
   */
   
	public function untagAccounts($accounts,$store = true){
		if(!$accounts){
	  		throw new MissingParamsException(["accounts"]);
	  	}
		if(!is_array($accounts) || !is_bool($store)){
			throw new InvalidParamTypeException([
	  			'accounts'=>'array',
	  			'store'=>'boolean'
	  		]);
		}
		
		$output = $this->_postRequest('untag_accounts', compact('accounts'));
		
		if($store){
			$this->store();
		}
		
		return $output;
	}

	/**
   *setAccountTagDescription
   * Describe a tag
   *
   * @param  string  $tag          Tag to describe
   * @param  string  $description  Description to apply to tag
   *
   * @return object  Example: {
   *   // TODO example
   * }
   *
   */
  public function setAccountTagDescription($tag, $description,$store = true){
  	
  	if(!$tag || !$description){
  		throw new MissingParamsException(["tag","description"]);
  	}
  	
  	if(!is_bool($store)){
		throw new InvalidParamTypeException([
  			'tag'=>'string',
  			'description'=>'string',
  			'store'=>'boolean'
  		]);
	}
	
	  
    $output = $this->_postRequest('set_account_tag_description', compact('tag','description'));
	
	if($store){
		$this->store();
	}
    
    return $output;
  }
  
  /**
   * getHeight
   * Look up how many blocks are in the longest chain known to the wallet
   *
   * @param  none
   *
   * @return object  Example: {
   *   "height": 994310
   * }
   *
   */
  public function getHeight(){
    return $this->_postRequest('get_height',[]);
  }
  
  /**
   *
   * Transfer
   * Send stellite coin
   * Step 
   *	1.	Add Transfer Destinations
   *	2.	Do Transfer
   * 
   * Parameters can be passed in individually (as listed below) or as an array (as listed at bottom)
   * The array containing any of the options listed below, where only amount and address of the destination are added using 
   * `transferAddDestination`. Checking of amount for a given address the function `transferDestinations` will return an array 
   * for the amounts(if multiple amounts) by passing address value as argument else it will display all destinations.
   * 
   * @param  string   $payment_id       Payment ID                                                (optional)
   * @param  number   $mixin            Mixin number (ringsize - 1)                               (optional)
   * @param  number   $account_index    Account to send from                                      (optional)
   * @param  string   $subaddr_indices  Comma-separated list of subaddress indices to spend from  (optional)
   * @param  number   $priority         Transaction priority                                      (optional)
   * @param  number   $unlock_time      UNIX time or block height to unlock output                (optional)
   * @param  boolean  $do_not_relay     Do not relay transaction                                  (optional)
   *
   *   OR
   *
   * @param  object  $params            
   *
   * @return object  Example: {
   *   "amount": "1000000000000",
   *   "fee": "1000020000",
   *   "tx_hash": "c60a64ddae46154a75af65544f73a7064911289a7760be8fb5390cb57c06f2db",
   *   "tx_key": "805abdb3882d9440b6c80490c2d6b95a79dbc6d1b05e514131a91768e8040b04"
   * }
   *
   */
   
    private $_transfer_destinations = [];
    
    /**
     * transferDestinations
     * 
     * @description	Displays amount(s) for an address for a destination it will return all destination if no address given
     * @param  string   $address  Address to receive funds
     *
     * @return array	
     */
    
    public function transferDestinations($address = ""){
    	if(empty($address)){
    		return $this->_transfer_destinations;
    	}
    	$output = [];
    	foreach($this->_transfer_destinations as $destination){
    		if($destination['address'] === $address){
    			$output[] = $destination['amount'];
    		}
    	}
    	return $output;
    }
    
    /**
     * transferAddDestination
     * 
     * @description	Add an amount for an address for a destination
     * @param  float | integer   $amount           Amount of stellite to send
     * @param  string   $address          Address to receive funds
     *
     * @return null
     */
	public function transferAddDestination($address,$amount){
		if (!is_float($amount) || !is_integer($amount)) {
        	throw new InvalidParamTypeException([
		  		'amount'=>'float | integer',
		  		'address'=>'string'
	  		]);
        }
		
	    $this->_transfer_destinations[] = compact('amount' ,'address');
	}
	
	/**
     * transfer
     * 
     * @description	Transfer transaction
     * @param  string	$address	Address to receive funds
     * @param  boolean  $store  	Either to store the transaction to blockchain
     * @param  boolean  $clear  	Clear all destinations after transaction
     * 
     * @return array	
     */
     
	public function transfer($options = [],$store=true,$clear=true){
		if(empty($this->_transfer_destinations)){
			throw new Exceptions('Missing destinations. Use `transferAddDestination` to add an address and amount');
		}
		
		$parameters = [
			'payment_id' => '', 
			'mixin' => 1,
			'account_index' => 0, 
			'subaddr_indices' => [],
			'priority' => 0,
			'unlock_time' => 0, 
			'do_not_relay' => false,
			'get_tx_metadata'=>false
		];
		
		$parameters = array_replace($parameters,$options);
	  
		$parameters['get_tx_key']=true;
		$parameters['get_tx_hex']=true;
			
	    $parameters['destinations'] = $this->_transfer_destinations;
	    
	    $output = $this->_postRequest('transfer', $parameters);
	    if($clear){
	    	$this->_transfer_destinations = [];
	    }
	    if($store){
	    	$this->store();
	    }
	    return $output;
	    
	  }
	  
	  
	/**
	*
	* sweepDust
	* Send all dust outputs back to the wallet
	*
	* @param  none
	*
	* @return object  
	*
	*/
  public function sweepDust(){
    return $this->_postRequest('sweep_dust');
  }
  
  
  /**
   * getPayments
   * Look up incoming payments by payment ID
   *
   * @param  string  $payment_id  Payment ID to look up
   *
   * @return object  Example: {
   *   "payments": [{
   *     "amount": 10350000000000,
   *     "block_height": 994327,
   *     "payment_id": "4279257e0a20608e25dba8744949c9e1caff4fcdafc7d5362ecf14225f3d9030",
   *     "tx_hash": "c391089f5b1b02067acc15294e3629a463412af1f1ed0f354113dd4467e4f6c1",
   *     "unlock_time": 0
   *   }]
   * }
   *
   */
  public function getPayments($payment_id)
  {
	if(!$payment_id){
  		throw new MissingParamsException(["payment_id"]);
  	}
	
    return $this->_postRequest('get_payments', compact('payment_id'));
  }
  

  
}