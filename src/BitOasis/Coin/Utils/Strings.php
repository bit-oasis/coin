<?php

namespace BitOasis\Coin\Utils;

use kornrunner\Keccak;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Strings {

	const SHA256 = 'sha256';

	protected function __construct() {
	}

	/**
	 * Hashes input $value two times with SHA256 algorithm
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 * @return string
	 */
	public static function sha256x2hash($value, $rawOutput = true) {
		return hash(self::SHA256, hash(self::SHA256, $value, $rawOutput), $rawOutput);
	}

	/**
	 * @todo Use original kornrunner\Keccak package after move min. PHP version to 7.1
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 * @return string
	 */
	public static function keccak256Hash($value, $rawOutput = true) {
		return Keccak::hash($value, 256, $rawOutput);
	}

	/**
	 * @param string $value as binary string
	 * @return string in hex format
	 */
	public static function convertBinaryStringToHex($value) {
		$tmp = unpack('H*', $value);
		return reset($tmp);
	}

	/**
	 * @param string $value as binary string
	 * @param bool $forceArray
	 * @return false|int|int[] if there is more than one char, function returns whole array, or false if there is no char
	 */
	public static function convertBinaryStringToDecimal($value, $forceArray = false) {
		$tmp = unpack('C*', $value);
		return ($forceArray || count($tmp) > 1) ? $tmp : reset($tmp);
	}

	/**
	 * @param int $value
	 * @return string as binary string
	 */
	public static function convertDecimalToBinaryString($value) {
		return pack('C*', $value);
	}

	/**
	 * @param string $value in hex foramt
	 * @return string as binary string
	 */
	public static function convertHexToBinaryString($value) {
		return pack('H*', $value);
	}

}
