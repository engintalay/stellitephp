# Stellite Library
A Stellite library written in PHP fork from [Monero Integrations](https://monerointegrations.com) [team](https://github.com/stellitecoin/stellitephp/graphs/contributors).

## How To Use

Using composer 
`composer require stellitecoin/stellitephp`

Include composer autoload
`require_once __DIR__ . '/vendor/autoload.php';`

This library has 3 main parts. All libraries now uses PSR-4 namespacing.
1. A Stellite daemon JSON RPC API wrapper, ( `\Stellite\Rpc\Daemon` )
2. A Stellite wallet (`daemon-wallet-rpc`) JSON RPC API wrapper,  ( `\Stellite\Rpc\Wallet` )

3. A Monero/Cryptonote toolbox, `cryptonote.php`, with both lower level functions used in Stellite related cryptography and higher level methods for things like generating Stellite private/public keys. (not yet refactored)

In addition to these features, there are other lower-level libraries included for portability, *eg.* an ed25519 library, a SHA3 library, *etc.*

## Preview
![Preview](master/docs/Screen%20Shot%202018-07-16%20at%204.35.07%20PM.png)

## Documentation

Documentation can be found in the [`/docs`](https://github.com/stellitecoin/stellitephp/tree/master/docs) folder.

## Configuration
### Requirements
 - Stellite daemon (`stellited`)
 - Webserver with PHP, for example XMPP, Apache, or NGINX
    - cURL PHP extension for JSON RPC API(s)
    - GMP PHP extension for about 100x faster calculations (as opposed to BCMath)

Debian (or Ubuntu) are recommended.
 
### Getting Started

1. Start the Stellite daemon (`stellited`) on testnet.
```bash
stellited --testnet --detach
```

2. Start the Stellite wallet RPC interface (`stellite-wallet-rpc`) on testnet.
```bash
stellite-wallet-rpc --testnet --rpc-bind-port 28083 --disable-rpc-login --wallet-dir /path/to/wallet/directory
```

3. Edit `example.php` with your the IP address of `stellited` and `stellite-wallet-rpc` (use `127.0.0.1:28081` and `127.0.0.1:28083`, respectively, for testnet.)

4. Serve `example.php` with your webserver (*eg.* XMPP, Apache/Apache2, NGINX, *etc.*) and navigate to it.  If everything has been set up correctly, information from your Stellite daemon and wallet will be displayed.
