<?php

namespace BitOasis\Coin\Utils;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Strings {

	protected function __construct() {
	}

	/**
	 * @param string $value as binary string
	 * @return string in hex format
	 */
	public static function convertBinaryStringToHex($value) {
		return bin2hex($value);
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
		return hex2bin($value);
	}

}
