<?php declare(strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use SulacoTech\Base58;

class Base58Test extends TestCase {

	public function testEncoding() {

		$bc = new Base58();

		$this->assertSame($bc->encode("Hello World!"), "2NEpo7TZRRrLZSi2U");
		$this->assertSame($bc->encode("The quick brown fox jumps over the lazy dog."), "USm3fpXnKG5EUBx2ndxBDMPVciP5hGey2Jh4NDv6gmeo1LkMeiKrLJUUBk6Z");
		$this->assertSame($bc->encode("\x00\x00\x28\x7f\xb4\xcd"), "11233QC4");
	}

	public function testDecoding() {

		$bc = new Base58();

		$this->assertSame($bc->decode("2NEpo7TZRRrLZSi2U"), "Hello World!");
		$this->assertSame($bc->decode("USm3fpXnKG5EUBx2ndxBDMPVciP5hGey2Jh4NDv6gmeo1LkMeiKrLJUUBk6Z"), "The quick brown fox jumps over the lazy dog.");
		$this->assertSame($bc->decode("11233QC4"), "\x00\x00\x28\x7f\xb4\xcd");
	}
}
