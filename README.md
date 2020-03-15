# base58-php

Pretty lightweight implementation of Base58 encoding and deconding algorithms written in PHP.

## Install

Install with [composer](https://getcomposer.org/).

``` bash
$ composer require sulaco-tech/base58
```

This branch requires PHP 7.0 or up.

## Usage

``` php

$base58 = new SulacoTech\Base58();

$data = "Hello World!";
$encoded = $base58->encode($data); // "2NEpo7TZRRrLZSi2U"
$decoded = $base58->decode($encoded); // "Hello World!"
```

## Character sets

Coder support few predefined charset sets for coding algorithms:
- [Bitcoin](https://github.com/bitcoin/bitcoin/blob/master/src/base58.cpp)
- [Flickr](https://www.flickr.com/groups/api/discuss/72157616713786392/)
- [Ripple](https://wiki.ripple.com/Accounts)
- [IPFS](https://github.com/richardschneider/net-ipfs-core#base58)

You can also use any custom 58 characters.
By default Base58Coder uses IPFS style character set.

```php
use SulacoTech\Base58;

print Base58::CHARSET_GMP;
// 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuv
print Base58::CHARSET_BITCOIN;
// 123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz
print Base58::CHARSET_FLICKR;
// 123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ
print Base58::CHARSET_RIPPLE;
// rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz
print Base58::CHARSET_IPFS;
// 123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz

$base58 = new Base58(Base58::CHARSET_FLICKR);
$data = "Hello World!";
$encoded = $base58->encode($data); // "2nePN7syqqRkyrH2t"
$decoded = $base58->decode($encoded); // "Hello World!"
```

## Testing

You can run tests with [phpunit](https://phpunit.de).

``` bash
$ phpunit tests
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.