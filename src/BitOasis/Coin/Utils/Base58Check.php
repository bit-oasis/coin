<?php

namespace BitOasis\Coin\Utils;

use StephenHill\Base58;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use BitOasis\Coin\Utils\Exception\InvalidChecksumException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Base58Check {

	const BTC_ADDRESS = 'btc';
	const LTC_ADDRESS = 'ltc';
	const XRP_ADDRESS = 'xrp';
	const BCH_LEGACY_ADDRESS = 'bchl';
	const ZEC_TRANSPARENT_ADDRESS = 'zect';
	const ZEC_SHIELDED_ADDRESS = 'zecz';
	
	const SHA256 = 'sha256';
	const VERSION_LENGTH = 'versionLength';
	const HASH_LENGTH = 'hashLength';
	const CHECKSUM_HASH = 'checksumHash';
	
	/** @var array */
	protected static $addressSettings = [
		self::BTC_ADDRESS => [
			self::VERSION_LENGTH => 1,
			self::HASH_LENGTH => 20,
			self::CHECKSUM_HASH => 'sha256x2hash',
		],
		self::ZEC_TRANSPARENT_ADDRESS => [
			self::VERSION_LENGTH => 2,
			self::HASH_LENGTH => 20,
			self::CHECKSUM_HASH => 'sha256x2hash',
		],
		self::ZEC_SHIELDED_ADDRESS => [
			self::VERSION_LENGTH => 2,
			self::HASH_LENGTH => 64,
			self::CHECKSUM_HASH => 'sha256x2hash',
		],
	];

	protected function __construct() {
	}

	/**
	 * @param string $address base58 encoded address
	 * @param string $charset if null default Bitcoin charset is used
	 * @param string|Base58CheckOptions $options
	 * @return Base58DecodedAddress
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	public static function decodeAddress($address, $charset = null, $options = self::BTC_ADDRESS) {
		$options = self::getOptions($options);
		$payload  = self::decode($address, $charset, $options->getChecksumHashFunction());
		
		try {
			return Base58DecodedAddress::fromPayload($payload, $options->getVersionLength(), $options->getHashLength());
		} catch (InvalidArgumentException $e) {
			throw new InvalidArgumentException($address . ' has invalid length!', 0, $e);
		}
	}

	/**
	 * @param Base58DecodedAddress
	 * @param string $charset if null default Bitcoin charset is used
	 * @param string|Base58CheckOptions $options
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeAddress(Base58DecodedAddress $address, $charset = null, $options = self::BTC_ADDRESS) {
		self::validateAddressAndOptions($address, $options);
		$options = self::getOptions($options);
		return self::encodeHash($address->getHash(), $address->getVersion(), $charset, $options);
	}

	/**
	 * @param string $hash as binary string
	 * @param string $version as binary string
	 * @param string $charset if null default Bitcoin charset is used
	 * @param string|Base58CheckOptions $options
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function encodeHash($hash, $version, $charset = null, $options = self::BTC_ADDRESS) {
		$options = self::getOptions($options);
		return self::encode($version . $hash, $charset, $options->getChecksumHashFunction());
	}

	/**
	 * @param string $value as binary string
	 * @param string $charset if null default Bitcoin charset is used
	 * @param string|Base58CheckOptions $options
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function decodeString($value, $charset = null, $options = self::BTC_ADDRESS) {
		$options = self::getOptions($options);
		return self::encode($value, $charset, $options->getChecksumHashFunction());
	}

	/**
	 * @param string $value as binary string
	 * @param string $charset if null default Bitcoin charset is used
	 * @param string|Base58CheckOptions $options
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeString($value, $charset = null, $options = self::BTC_ADDRESS) {
		$options = self::getOptions($options);
		return self::encode($value, $charset, $options->getChecksumHashFunction());
	}

	/**
	 * @param string $value base58 encoded string
	 * @param string $charset if null default Bitcoin charset is used
	 * @param callable $checksumHash function(string $value) : string
	 * @return string binary string
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	protected static function decode($value, $charset = null, callable $checksumHash = null) {
		try {
			$base58 = new Base58($charset);
			$decodedValue = $base58->decode($value);

			$payload = substr($decodedValue, 0, -4);
			$checksum = unpack('C*', substr($decodedValue, -4));
			$newChecksum = unpack('C*', $checksumHash === null ? self::sha256x2hash($payload) : $checksumHash($payload));
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
	 * @param string $charset if null default Bitcoin charset is used
	 * @param callable $checksumHash function(string $value) : string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	protected static function encode($value, $charset = null, callable $checksumHash = null) {
		try {
			$checksum = substr($checksumHash === null ? self::sha256x2hash($value) : $checksumHash($value), 0, 4);
			
			$base58 = new Base58($charset);
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

	/**
	 * @param string|Base58CheckOptions $options
	 * @return Base58CheckOptions
	 * @throws InvalidArgumentException
	 */
	protected static function getOptions($options = null) {
		$options = $options === null ? self::BTC_ADDRESS : $options;
		if ($options instanceof Base58CheckOptions) {
			return $options;
		}
		if (!is_string($options)) {
			throw new InvalidArgumentException('Type ' . gettype($options) . ' is not valid option type!');
		}
		
		$addressType = self::convertAddressTypeAlias($options);
		if (!isset(self::$addressSettings[$addressType])) {
			throw new InvalidArgumentException("'$addressType' is not valid address type!");
		}
		
		$settings = self::$addressSettings[$addressType];
		return new Base58CheckOptions($settings[self::VERSION_LENGTH], $settings[self::HASH_LENGTH], [self::class, $settings[self::CHECKSUM_HASH]]);
	}

	/**
	 * @param string $addressType
	 * @return string
	 */
	protected static function convertAddressTypeAlias($addressType) {
		$aliases = [self::BCH_LEGACY_ADDRESS => self::BTC_ADDRESS, self::LTC_ADDRESS => self::BTC_ADDRESS];
		return isset($aliases[$addressType]) ? $aliases[$addressType] : $addressType;
	}

	/**
	 * @param Base58DecodedAddress $address
	 * @param $options
	 * @throws InvalidArgumentException
	 */
	protected static function validateAddressAndOptions(Base58DecodedAddress $address, $options = null) {
		if ($options instanceof Base58CheckOptions) {
			if ($address->getVersionLength() !== $options->getVersionLength() || $address->getHashLength() !== $options->getHashLength()) {
				throw new InvalidArgumentException('Address and options length mismatch!');
			}
		}
	}

}
