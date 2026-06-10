<?php

namespace BitOasis\Coin\Utils;

use kornrunner\Keccak;
use SodiumException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Hashes {

	const SHA256 = 'sha256';

	protected function __construct() {
	}

	/**
	 * Hashes input $value two times with SHA256 algorithm
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 */
	public static function sha256x2(string $value, bool $rawOutput = true): string {
		return \hash(self::SHA256, \hash(self::SHA256, $value, $rawOutput), $rawOutput);
	}

	/**
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 */
	public static function keccak256(string $value, bool $rawOutput = true): string {
		return Keccak::hash($value, 256, $rawOutput);
	}

	/**
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 */
	public static function blake2b256(string $value, bool $rawOutput = true): string {
		$tmp = \sodium_crypto_generichash($value);
		return $rawOutput ? $tmp : \bin2hex($tmp);
	}

	/**
	 * Hashes input $value with blake2b256 and then keccak256 algorithm
	 * @param string $value
	 * @param bool $rawOutput if true returned value is in binary string
	 */
	public static function blake2b256Keccak256(string $value, bool $rawOutput = true): string {
		return self::keccak256(self::blake2b256($value), $rawOutput);
	}

	/**
	 * @param string $value
	 * @param bool $rawOutput
	 * @throws SodiumException
	 */
	public static function blake2b512(string $value, bool $rawOutput = true): string {
		$tmp = \sodium_crypto_generichash($value, '', 64);
		return $rawOutput ? $tmp : \bin2hex($tmp);
	}

	/**
	 * Note: In Filecoin specification the hash is called blake2b-4
	 * @param string $value
	 * @param bool $rawOutput
	 * @throws SodiumException
	 */
	public static function blake2b32(string $value, bool $rawOutput = true): string {
		$tmp = \ParagonIE_Sodium_Crypto::generichash($value, '', 4);

		return $rawOutput ? $tmp : \bin2hex($tmp);
	}
}
