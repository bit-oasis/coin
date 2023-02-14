<?php

namespace BitOasis\Coin\Utils\Base58Check;

use BitOasis\Coin\Utils\Strings;
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
	const WAVES_ADDRESS = 'waves';
	const BCH_LEGACY_ADDRESS = 'bchl';
	const ZEC_TRANSPARENT_ADDRESS = 'zect';
	const ZEC_SHIELDED_ADDRESS = 'zecz';
	
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
		self::WAVES_ADDRESS => [
			self::VERSION_LENGTH => 2,
			self::HASH_LENGTH => 20,
			self::CHECKSUM_HASH => 'blake2b256Keccak256Hash',
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
	 * @param Base58DecodedAddress $address
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
	public static function encodeHash($hash, $version, $charset = null, $options = self::BTC_ADDRESS) {
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
		return self::decode($value, $charset, $options->getChecksumHashFunction());
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
			$checksum = Strings::convertBinaryStringToDecimal(substr($decodedValue, -4), true);
			$newChecksum = Strings::convertBinaryStringToDecimal($checksumHash === null ? Strings::sha256x2hash($payload) : $checksumHash($payload), true);
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
			$checksum = substr($checksumHash === null ? Strings::sha256x2hash($value) : $checksumHash($value), 0, 4);
			
			$base58 = new Base58($charset);
			return $base58->encode($value . $checksum);
		} catch (\InvalidArgumentException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
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
		return new Base58CheckOptions($settings[self::VERSION_LENGTH], $settings[self::HASH_LENGTH], [Strings::class, $settings[self::CHECKSUM_HASH]]);
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
