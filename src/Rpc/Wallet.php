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
		if(is_array($account_index)){
			$account_index = (isset($account_index['account_index']))?$account_index['account_index']:0;
		}
		
		if(!is_integer($account_index)){
			return false;
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
		if(is_array($account_index)){
			
			$address_index = (isset($account_index['address_index']))?$account_index['address_index']:0;
			$account_index = (isset($account_index['account_index']))?$account_index['account_index']:0;
			
			
			
		}
		
		if(!is_integer($account_index) || !is_integer($address_index)){
			return false;
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
		if(is_array($account_index)){
			
			$label = (isset($account_index['label']))?$account_index['label']:'';
			$store = (isset($account_index['store']))?$account_index['store']:true;
			$account_index = (isset($account_index['account_index']))?$account_index['account_index']:0;
			
		}
		
		if(!is_integer($account_index) || !is_string($label) || !is_bool($store)){
			return false;
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
	
	public function labelAddress($index, $label = true){
    	if(is_array($index)){
			
			$label = (isset($index['label']))?$index['label']:'';
			$index = (isset($index['index']))?$index['index']:0;

		}
		
		if(!is_integer($index) || !is_string($label)){
			return false;
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
    return $this->_postRequest('get_accounts',[]);
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
  	if(is_array($label)){
  		
		$store = (isset($label['store']))?$label['store']:true;
		$label = isset($label['label'])?$label['label']:'';
  	}
  	
  	if(!is_string($label) || !is_bool($store)){
		return false;
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
    if(is_array($account_index)){
  		
		$store = isset($account_index['store'])?$account_index['store']:true;
		$label = isset($account_index['label'])?$account_index['label']:'';
		$account_index = (isset($account_index['account_index']))?$account_index['account_index']:0;
		
  	}
  	
  	if(!is_string($label) || !is_integer($account_index) || !is_bool($store)){
		return false;
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
  	if(is_array($accounts)){
  		if(!isset($accounts['accounts']) || !isset($accounts['tag'])){
  			return false;
  		}
  		
		$store = isset($accounts['store'])?$accounts['store']:true;
		$tag = $accounts['tag'];
		$accounts = $accounts['accounts'];
		
  	}
  	
  	if(!is_string($label) || !is_integer($account_index) || !is_bool($store)){
		return false;
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
    if(is_array($accounts)){
  		if(!isset($accounts['accounts'])){
  			return false;
  		}
  		
		$store = isset($accounts['store'])?$accounts['store']:true;
		$accounts = $accounts['accounts'];
		
  	}
  	
  	if(!is_integer($accounts) || !is_bool($store)){
		return false;
	}
	
	$output = $this->_postRequest('untag_accounts', compact('accounts'));
	
	if($store){
		$this->store();
	}
    
    return $output;
  }
  
}