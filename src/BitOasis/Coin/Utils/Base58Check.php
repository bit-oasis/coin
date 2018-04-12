<?php

namespace BitOasis\Coin\Utils;

use StephenHill\Base58;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use BitOasis\Coin\Utils\Exception\InvalidChecksumException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Base58Check {

	const SHA256 = 'sha256';

	protected function __construct() {
	}

	/**
	 * @param string $address base58 encoded address
	 * @return Base58DecodedAddress
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	public static function decodeAddress($address) {
		$payload  = self::decode($address);
		
		try {
			return Base58DecodedAddress::fromPayload($payload);
		} catch (InvalidArgumentException $e) {
			throw new InvalidArgumentException($address . ' has invalid length!', 0, $e);
		}
	}

	/**
	 * @param Base58DecodedAddress
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeAddress(Base58DecodedAddress $address) {
		return self::encodeHash($address->getHash(), $address->getVersion());
	}

	/**
	 * @param string $hash as binary string
	 * @param string $version as binary string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function encodeHash($hash, $version) {
		return self::encode($version . $hash);
	}

	/**
	 * @param string $value base58 encoded string
	 * @return string binary string
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	public static function decode($value) {
		try {
			$base58 = new Base58();
			$decodedValue = $base58->decode($value);

			$payload = substr($decodedValue, 0, -4);
			$checksum = unpack('C*', substr($decodedValue, -4));
			$newChecksum = unpack('C*', self::sha256x2hash($payload));
			for ($i = 1; $i < 5; $i++) {
				if ($checksum[$i] !== $newChecksum[$i]) {
					throw new InvalidChecksumException('Invalid checksum!');
				}
			}
			
			return $payload;
		} catch (\InvalidArgumentException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

	/**
	 * @param string $value as binary string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encode($value) {
		try {
			$checksum = substr(self::sha256x2hash($value), 0, 4);
			
			$base58 = new Base58();
			return $base58->encode($value . $checksum);
		} catch (\InvalidArgumentException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

	/**
	 * Hashes input $value two times with SHA256 algorithm
	 * @param string $value
	 * @param bool $rawOutput if true returned values is in binary string
	 * @return string
	 */
	public static function sha256x2hash($value, $rawOutput = true) {
		return hash(self::SHA256, hash(self::SHA256, $value, $rawOutput), $rawOutput);
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
	 * @return int|int[] if there is more than one char, function returns whole array
	 */
	public static function convertBinaryStringToDecimal($value) {
		$tmp = unpack('C*', $value);
		return count($tmp) > 0 ? reset($tmp) : $tmp;
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
