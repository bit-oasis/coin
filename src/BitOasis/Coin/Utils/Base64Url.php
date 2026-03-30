<?php

namespace BitOasis\Coin\Utils;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class Base64Url {

	public static function encode(string $string): string {
		$b64 = base64_encode($string);
		$url = strtr($b64, '+/', '-_');
		return rtrim($url, '=');
	}

	/**
	 * @return string|bool returns the decoded data or false on failure.
	 */
	public static function decode(string $string, bool $strict = false) {
		$b64 = strtr($string, '-_', '+/');
		return base64_decode($b64, $strict);
	}
}