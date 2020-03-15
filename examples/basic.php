<?php declare(strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';

use SulacoTech\Base58;

$base58 = new Base58();

$data = "Hello World!";
$encoded = $base58->encode($data);
$decoded = $base58->decode($encoded);

var_dump($data);
var_dump($encoded);
var_dump($decoded);
