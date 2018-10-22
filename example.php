<?php

// Make sure to display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';



$daemonRPC = new \Stellite\Rpc\Daemon('http://testnet.xtlpool.com:20189'); // Change to match your daemon (stellited) IP address and port; 20189 is the default port for mainnet, 28081 for testnet
$daemonRPC->isArray = false;
$getblockcount = $daemonRPC->getblockcount();
$ongetblockhash = $daemonRPC->on_getblockhash([466]);
$get_info = $daemonRPC->get_info();

$getlastblockheader = $daemonRPC->getlastblockheader();

$get_connections = $daemonRPC->get_connections();


$hardfork_info = $daemonRPC->hard_fork_info();
// echo "<pre>";
// var_dump($hardfork_info);
// die;
// $setbans = $daemonRPC->setbans('8.8.8.8');
// $getbans = $daemonRPC->getbans();


// $walletRPC = new \Stellite\Rpc\Wallet('http://127.0.0.1:18081'); // Change to match your wallet (monero-wallet-rpc) IP address and port; 18083 is the customary port for mainnet, 28083 for testnet, 38083 for stagenet
// $create_wallet = $walletRPC->createWallet('stellite_wallet', ''); // Creates a new wallet named monero_wallet with no passphrase.  Comment this line and edit the next line to use your own wallet
// $open_wallet = $walletRPC->openWallet('stellite_wallet', '');
// $walletRPC->isArray = false;
// $open_wallet = $walletRPC->createAddress(0, 'stellite_sub_addresses');
// $get_address = $walletRPC->getAddress();
// $get_accounts = $walletRPC->getAccounts();
// $get_balance = $walletRPC->getBalance();

// $create_address = $walletRPC->create_address(0, 'This is an example subaddress label'); // Create a subaddress on account 0
// $tag_accounts = $walletRPC->tag_accounts([0], 'This is an example account tag');
// $get_height = $walletRPC->get_height();
// $transfer = $walletRPC->transfer(1, '9sZABNdyWspcpsCPma1eUD5yM3efTHfsiCx3qB8RDYH9UFST4aj34s5Ygz69zxh8vEBCCqgxEZxBAEC4pyGkN4JEPmUWrxn'); // First account generated from mnemonic 'gang dying lipstick wonders howls begun uptight humid thirsty irony adept umpire dusted update grunt water iceberg timber aloof fudge rift clue umpire venomous thirsty'
// $transfer = $walletRPC->transfer(['address' => '9sZABNdyWspcpsCPma1eUD5yM3efTHfsiCx3qB8RDYH9UFST4aj34s5Ygz69zxh8vEBCCqgxEZxBAEC4pyGkN4JEPmUWrxn', 'amount' => 1, 'priority' => 1]); // Passing parameters in as array
// $transfer = $walletRPC->transfer(['destinations' => ['amount' => 1, 'address' => '9sZABNdyWspcpsCPma1eUD5yM3efTHfsiCx3qB8RDYH9UFST4aj34s5Ygz69zxh8vEBCCqgxEZxBAEC4pyGkN4JEPmUWrxn', 'amount' => 2, 'address' => 'BhASuWq4HcBL1KAwt4wMBDhkpwseFe6pNaq5DWQnMwjBaFL8isMZzcEfcF7x6Vqgz9EBY66g5UBrueRFLCESojoaHaTPsjh'], 'priority' => 1]); // Multiple payments in one transaction
// $sweep_all = $walletRPC->sweep_all('9sZABNdyWspcpsCPma1eUD5yM3efTHfsiCx3qB8RDYH9UFST4aj34s5Ygz69zxh8vEBCCqgxEZxBAEC4pyGkN4JEPmUWrxn');
// $sweep_all = $walletRPC->sweep_all(['address' => '9sZABNdyWspcpsCPma1eUD5yM3efTHfsiCx3qB8RDYH9UFST4aj34s5Ygz69zxh8vEBCCqgxEZxBAEC4pyGkN4JEPmUWrxn', 'priority' => 1]);
// $get_transfers = $walletRPC->get_transfers('in', true);
// $incoming_transfers = $walletRPC->incoming_transfers('all');
// $mnemonic = $walletRPC->mnemonic();

?>
<html>
  <body>
    <h1>
      <a href="https://github.com/stellitecoin/stellitephp" title="Stellite Coin">
        <img src="./docs/logo.png" height="22pt" style="height: 1em; margin-bottom: -4pt" /> <!-- Image source is just base64-encoded -->
        StellitePHP
      </a>
    </h1>   
    <p>StellitePHP was fork from the original <a href="https://github.com/monero-integrations/monerophp/graphs/contributors">Monero-Integrations team</a>! Please report any issues or request additional features at <a href="https://github.com/stellitecoin/stellitephp/issues">github.com/stellitecoin/stellitephp</a>.</p>

    <h2><tt>\Stellite\Rpc\Daemon</tt> example</h2>
    <p><i>Note: not all methods shown, nor all results from each method.</i></p>
    <dl>
      <dt><tt>getblockcount()</tt></dt>
      <dd>
        <p>Status: <tt><?php echo $getblockcount['status']; ?></tt></p>
        <p>Height: <tt><?php echo $getblockcount['count']; ?></tt></p>
      </dd>
      <dt><tt>on_getblockhash(42069)</tt></dt>
      <dd>
        <p>Block hash: <tt><?php echo $ongetblockhash; ?></tt></p>
      </dd>
      
      <dt><tt>getlastblockheader()</tt></dt>
      <dd>
        <p>Current block hash: <tt><?php echo $getlastblockheader['block_header']['hash']; ?></tt></p>
        <p>Previous block hash: <tt><?php echo $getlastblockheader['block_header']['prev_hash']; ?></tt></p>
      </dd>
      
      <dt><tt>get_connections()</tt></dt>
      <dd>
        <p>Connections: <?php echo $get_connections?count($get_connections):0; ?></p>
        <!-- <?php foreach ($get_connections as $peer) { echo '<p><tt>' . $peer['address'] . ' (' . ( $peer['height'] == $getblockcount['count'] ? 'synced' : ( $peer['height'] > $getblockcount['count'] ? 'ahead; syncing' : 'behind; syncing') ). ')</tt></p>'; } ?> -->
      </dd>
      <dt><tt>get_info()</tt></dt>
      <dd>
        <p>Difficulty: <tt><?php echo $get_info['difficulty']; ?></tt></p>
        <p>Cumulative difficulty: <tt><?php echo $get_info['cumulative_difficulty']; ?></tt></p>
      </dd>
      <dt><tt>hard_fork_info()</tt></dt>
      <dd>
        <p>Status: <tt><?php echo $hardfork_info['status']; ?></tt></p>
      </dd>
    </dl>
<?php /*
    <h2><tt>\Stellite\Rpc\Wallet</tt> example</h2>
    <p><i>Note: not all methods shown, nor all results from each method.</i></p>
    <dl>
      <!--
      <dt><tt>get_address()</tt></dt>
      <dd>
        <?php
        //foreach ($get_address['addresses'] as $account) { echo '<p>' . $account['label'] . ': <tt>' . $account['address'] . '</tt></p>'; } 
        ?>
      </dd>
      -->
      <dt><tt>get_accounts()</tt></dt>
      <dd>
        <p>Accounts: <?php echo count($get_accounts['subaddress_accounts']); ?></p>
        <?php
          foreach ($get_accounts['subaddress_accounts'] as $account) {
            echo '<p>Account ' . $account['account_index'] . ': <tt>' . $account['base_address'] . '</tt><br />';
            echo 'Balance: <tt>' . $account['balance'] / pow(10, 12) . '</tt> (<tt>' . $account['unlocked_balance'] / pow(10, 12) . '</tt> unlocked)<br />';
            echo ( $account['label'] ) ? 'Label: <tt>' . $account['label'] . '</tt><br />' : '';
            echo ( $account['tag'] ) ? 'Tag: <tt>' . $account['tag'] . '</tt><br />' : '';
            echo '</p>';
          }
        ?>
      </dd>
      <dt><tt>getBalance()</tt></dt>
      <dd>
        <p>Balance: <tt><?php echo $get_balance['balance'] / pow(10, 12); ?></tt></p>
        <p>Unlocked balance: <tt><?php echo $get_balance['unlocked_balance'] / pow(10, 12); ?></tt></p>
      </dd>
    </dl>
    
    */?>
  </body>
  <!-- ignore the code below, it's just CSS styling -->
  <head>
    <style>
      body {
        color: #fff;
        background: #000;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif;
      }

      a, a:active, a:hover, a:visited {
        text-decoration: none;
        display: inline-block;
        position: relative;
        color: #ff6600;
      }
      a::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #ff6600;
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
      }
      a:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
      }

      dt tt {
        padding: 0.42em;
        background: #4c4c4c;
        text-shadow: 1px 1px 0px #000;
      }
      dd tt {
        font-size: 14px;
      }
    </style>
  </head>
</html>
 