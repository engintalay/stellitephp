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


class Daemon extends Base{
  protected $_interface = [
      'getblockcount'=>['isRpc'=>true,'params'=>false],
      'on_getblockhash'=>['isRpc'=>true,'params'=>[]],
      'getblocktemplate'=>['isRpc'=>true,'params'=>['wallet_address','reserve_size']],
      'submitblock'=>['isRpc'=>true,'params'=>[]],
      'getlastblockheader'=>['isRpc'=>true,'params'=>false],
      'getblockheaderbyhash'=>['isRpc'=>true,'params'=>['hash']],
      'getblockheaderbyheight'=>['isRpc'=>true,'params'=>['height']],
      'getblockheadersrange'=>['isRpc'=>true,'params'=>['start_height','end_height']],
      'get_block'=>['isRpc'=>true,'params'=>['OR'=>['height','hash']]],
      'get_connections'=>['isRpc'=>true,'params'=>false],
      'get_info'=>['isRpc'=>true,'params'=>false],
      'hard_fork_info'=>['isRpc'=>true,'params'=>false],
      // 'set_bans'
      // 'get_bans'
      // 'flush_txpool'
      // 'get_output_histogram'
      'get_version'=>['isRpc'=>true,'params'=>false],
      'get_coinbase_tx_sum'=>['isRpc'=>true,'params'=>['height','count']],
      'get_fee_estimate'=>['isRpc'=>true,'params'=>[]],
      // 'get_alternate_chains'
      'relay_tx'=>['isRpc'=>true,'params'=>['txids']],
      'sync_info'=>['isRpc'=>true,'params'=>false],
      // 'get_txpool_backlog'
      // 'get_output_distribution'
      "get_height"=>['isRpc'=>false,'params'=>false],
      "get_blocks.bin"=>['isRpc'=>false,'params'=>['block_ids','start_height','prune']],
      'gettransactions'=>['isRpc'=>false,'params'=>['txs_hashes']],
      // /get_blocks_by_height.bin
      // /get_hashes.bin
      // /get_o_indexes.bin
      // /get_random_outs.bin
      // /get_outs.bin
      // /get_random_rctouts.bin
      // /get_transactions
      // /get_alt_blocks_hashes
      // /is_key_image_spent
      // /send_raw_transaction
      // /start_mining
      // /stop_mining
      // /mining_status
      // /save_bc
      // /get_peer_list
      // /set_log_hash_rate
      // /set_log_level
      // /set_log_categories
      // /get_transaction_pool
      // /get_transaction_pool_hashes.bin
      // /get_transaction_pool_stats
      // /get_limit
      // /set_limit
      // /out_peers
      // /in_peers
      // /start_save_graph
      // /stop_save_graph
      // /get_outs
      // /update

    ];

	

}
