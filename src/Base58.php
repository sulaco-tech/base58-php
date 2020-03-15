<?php declare(strict_types = 1);

namespace SulacoTech;

use function str_split;
use function array_combine;
use function array_values;
use function array_keys;
use function array_map;
use function array_reduce;
use function array_unshift;
use function array_slice;
use function intdiv;
use function count;
use function ord;
use function chr;

/**
 * Class which implements Base58 encoding/decoding algorithms.
 */
class Base58 {

	// charsets

	const CHARSET_GMP = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuv";
	const CHARSET_BITCOIN = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
	const CHARSET_FLICKR = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
	const CHARSET_RIPPLE = "rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz";
	const CHARSET_IPFS = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

	private $forwardTranslation;
	private $backTranslation;
	private $targetBase;

	/**
	 * @param string $charser Characters set for encoding to Base58. By default uses IPFS style character set.
	 */
	public function __construct(string $charset = self::CHARSET_IPFS) {

		$characters = str_split($charset);
		$this->forwardTranslation = $characters;
		$this->backTranslation = array_combine(array_values($characters), array_keys($characters));
		$this->targetBase = count($characters);
	}

	/**
	 * Encode given data to a encoded string.
	 *
	 * @param string $data Data as string to be encoded.
	 *
	 * @return string Encoded data as string.
	 */
	public function encode(string $data): string {

		$data = str_split($data);
		$data = array_map(function ($code) { return ord($code); }, $data);

		list ($leadingZeros, $data) = $this->removeLeadingZeroes($data);

		$converted = $this->convert($data, 256, $this->targetBase);
		$converted = [ ...$leadingZeros, ...$converted ];

		return array_reduce($converted, function ($result, $i) {
			return $result . $this->forwardTranslation[$i];
		});

	}

	/**
	 * Decode given encoded string back to data.
	 *
	 * @param string $data Encoded string to decode.
	 *
	 * @return string Decoded data as string.
	 */
	public function decode(string $data): string {

		$data = str_split($data);
		$data = array_map(function ($key) {
			return $this->backTranslation[$key];
		}, $data);

		list ($leadingZeros, $data) = $this->removeLeadingZeroes($data);

		$converted = $this->convert($data, $this->targetBase, 256);
		$converted = [ ...$leadingZeros, ...$converted ];
		
		return array_reduce($converted, function ($result, $code) {
			return $result . chr($code);
		});
	}

	/**
	 * Remove leading zeros from data array and returns two parts of array, first part is a leading zeros, second is a rest of data array.
	 *
	 * @return array An array with results, first element is an array with leading zeros, second is a rest of data.
	 */
	private function removeLeadingZeroes(array $data): array {
		for ($i = 0, $length = count($data); $i < $length && $data[$i] === 0; $i ++);
		$leadingZeros = array_slice($data, 0, $i);
		$data = array_slice($data, $i);
		return [ $leadingZeros, $data ];
	}

	/**
	 * Convert an integer between artbitrary bases
	 *
	 * @see https://tools.ietf.org/html/draft-msporny-base58-01
	 * @see http://codegolf.stackexchange.com/a/21672
	 *
	 * @param array $source An array which represents a number to convert.
	 * @param int $sourceBase Source base of number.
	 * @param int $targetBase Target base of number.
	 *
	 * @return array An array which represents a number in target base.
	 *
	 */
	private function convert(array $source, int $sourceBase, int $targetBase): array {

		$result = [];

		while ($length = count($source)) {

			$quotient = [];
			$remainder = 0;

			for ($i = 0; $i < $length; $i ++) {
				$accumulator = $source[$i] + $remainder * $sourceBase;
				$digit = intdiv($accumulator, $targetBase); // ($accumulator - ($accumulator % $targetBase)) / $targetBase;
				$remainder = $accumulator % $targetBase;
				if (count($quotient) || $digit) {
					$quotient[] = $digit;
				}
			}

			array_unshift($result, $remainder);

			$source = $quotient;
		}

		return $result;
	}
}
