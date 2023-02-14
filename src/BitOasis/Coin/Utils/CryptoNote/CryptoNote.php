<?php

namespace BitOasis\Coin\Utils\CryptoNote;

use BitOasis\Coin\Utils\Strings;
use StephenHill\Base58;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use BitOasis\Coin\Utils\Exception\InvalidChecksumException;

/**
 * Base CryptoNote implementation for Monero support
 * @author David Fiedor <davefu@seznam.cz>
 */
class CryptoNote {
	
	const FULL_BLOCK_SIZE = 8;
	const FULL_ENCODED_BLOCK_SIZE = 11;
	protected static $encodedBlockSizes = [0, 2, 3, 5, 6, 7, 9, 10, 11];

	protected function __construct() {
	}

	/**
	 * @param string $address CryptoNote encoded address
	 * @return CryptoNoteDecodedAddress
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	public static function decodeAddress($address) {
		$payload  = self::decode($address);
		
		try {
			return CryptoNoteDecodedAddress::fromPayload($payload);
		} catch (InvalidArgumentException $e) {
			throw new InvalidArgumentException($address . ' has invalid length!', 0, $e);
		}
	}

	/**
	 * @param CryptoNoteDecodedAddress $address
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeAddress(CryptoNoteDecodedAddress $address) {
		return self::encodeHashParts($address->getSpendKey(), $address->getViewKey(), $address->getVersion(), $address->getPaymentId());
	}

	/**
	 * @param string $spendKey as binary string
	 * @param string $viewKey as binary string
	 * @param string $version as binary string
	 * @param string $paymentId as binary string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeHashParts($spendKey, $viewKey, $version, $paymentId = null) {
		return self::encode($version . $spendKey . $viewKey . $paymentId);
	}

	/**
	 * @param string $value as binary string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function decodeString($value) {
		return self::encode($value);
	}

	/**
	 * @param string $value as binary string
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public static function encodeString($value) {
		return self::encode($value);
	}

	/**
	 * @param string $value
	 * @return string|null as binary string
	 * @throws InvalidArgumentException
	 * @throws InvalidChecksumException
	 */
	public static function decode($value) {
		try {
			$valueLength = strlen($value);
			if ($valueLength === 0) {
				return null;
			}
			
			$fullBlockSizeCount = (int)($valueLength / self::FULL_ENCODED_BLOCK_SIZE);
			$lastBlockSize = $valueLength % self::FULL_ENCODED_BLOCK_SIZE;
			$buffer = [];
			
			$base58 = new Base58();
			for ($i = 0; $i < $fullBlockSizeCount; $i++) {
				$decoded = $base58->decode(substr($value, $i * self::FULL_ENCODED_BLOCK_SIZE, self::FULL_ENCODED_BLOCK_SIZE));
				$buffer[] = self::trimNullBytes($decoded);
			}
			if ($lastBlockSize > 0) {
				if (!in_array($lastBlockSize, self::$encodedBlockSizes)) {
					throw new InvalidArgumentException($lastBlockSize . ' is not valid encoded block size!');
				}
				$decoded = $base58->decode(substr($value, $fullBlockSizeCount * self::FULL_ENCODED_BLOCK_SIZE, $lastBlockSize));
				$buffer[] = self::trimNullBytes($decoded, array_search($lastBlockSize, self::$encodedBlockSizes));
			}
			
			$decodedValue = implode('', $buffer);
			$payload = substr($decodedValue, 0, -4);
			$checksum = Strings::convertBinaryStringToDecimal(substr($decodedValue, -4), true);
			$newChecksum = Strings::convertBinaryStringToDecimal(Strings::keccak256Hash($payload), true);
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
	 * @return string|null
	 * @throws InvalidArgumentException
	 */
	public static function encode($value) {
		try {
			$valueLength = strlen($value);
			if ($valueLength === 0) {
				return null;
			}
			$valueLength += 4; //add checksum length
			
			
			$value .= substr(Strings::keccak256Hash($value), 0, 4);
			$fullBlockSizeCount = (int)($valueLength / self::FULL_BLOCK_SIZE);
			$lastBlockSize = $valueLength % self::FULL_BLOCK_SIZE;
			$buffer = [];
			
			$base58 = new Base58();
			for ($i = 0; $i < $fullBlockSizeCount; $i++) {
				$encoded = $base58->encode(substr($value, $i * self::FULL_BLOCK_SIZE, self::FULL_BLOCK_SIZE));
				$buffer[] = self::padBlock($encoded, self::FULL_ENCODED_BLOCK_SIZE);
			}
			if ($lastBlockSize > 0) {
				if (!isset(self::$encodedBlockSizes[$lastBlockSize])) {
					throw new InvalidArgumentException($lastBlockSize . ' is not valid block size!');
				}
				$encoded = $base58->encode(substr($value, $fullBlockSizeCount * self::FULL_BLOCK_SIZE, $lastBlockSize));
				$buffer[] = self::padBlock($encoded, self::$encodedBlockSizes[$lastBlockSize]);
			}
			
			return implode('', $buffer);
		} catch (\InvalidArgumentException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

	/**
	 * @param string $value as binary string
	 * @param int $length
	 * @return string as binary string
	 */
	protected static function trimNullBytes($value, $length = self::FULL_BLOCK_SIZE) {
		if (!isset(self::$encodedBlockSizes[$length])) {
			throw new InvalidArgumentException($length . ' is not valid decoded block length!');
		}
		$valueLength = strlen($value);
		if ($valueLength <= $length) {
			return $value;
		}
		if (trim(substr($value, 0, $valueLength - $length), "\x00") !== '') {
			throw new InvalidArgumentException('Invalid decoded block length!');
		}
		
		return substr($value, -$length);
	}

	/**
	 * @param string $value
	 * @param int $padLength
	 * @return string
	 */
	protected static function padBlock($value, $padLength) {
		return str_pad($value, $padLength, '1', STR_PAD_LEFT);
	}

}
