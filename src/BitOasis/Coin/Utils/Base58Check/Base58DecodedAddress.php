<?php

namespace BitOasis\Coin\Utils\Base58Check;

use BitOasis\Coin\Utils\Strings;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Base58DecodedAddress {

	/** @var string as binary string */
	protected $hash;

	/** @var string as binary string */
	protected $version;

	/** @var int */
	protected $versionLength;

	/** @var int */
	protected $hashLength;

	/**
	 * @param string $hash as binary string
	 * @param string $version as binary string
	 * @param int $versionLength expected version length
	 * @param int $hashLength expected hash length
	 * @throws InvalidArgumentException
	 */
	public function __construct($hash, $version, $versionLength = 1, $hashLength = 20) {
		self::validateLengths($versionLength, $hashLength);
		$this->hash = $hash;
		$this->version = $version;
		$this->versionLength = $versionLength;
		$this->hashLength = $hashLength;
	}

	/**
	 * @param string $payload as binary string
	 * @param int $versionLength expected version length
	 * @param int $hashLength expected hash length
	 * @return static
	 * @throws InvalidArgumentException
	 */
	public static function fromPayload($payload, $versionLength = 1, $hashLength = 20) {
		self::validateLengths($versionLength, $hashLength);
		if (strlen($payload) !== ($versionLength + $hashLength)) {
			throw new InvalidArgumentException('Invalid payload length!');
		}
		
		return new static(substr($payload, $versionLength), substr($payload, 0, $versionLength), $versionLength, $hashLength);
	}

	/**
	 * @return string as binary string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * @return string as binary string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return string in hex string
	 */
	public function getHexVersion() {
		return Strings::convertBinaryStringToHex($this->version);
	}

	/**
	 * @return string in hex string
	 */
	
	public function getHexVersionLower() {
		return strtolower($this->getHexVersion());
	}

	/**
	 * @return string in hex string
	 */
	
	public function getHexVersionUpper() {
		return strtoupper($this->getHexVersion());
	}

	/**
	 * @return int
	 */
	public function getDecimalVersion() {
		return Strings::convertBinaryStringToDecimal($this->version);
	}

	/**
	 * @param string $version as binary string
	 */
	public function setVersion($version) {
		$this->version = $version;
	}

	/**
	 * @param string $version in hex format
	 */
	public function setHexVersion($version) {
		$this->version = Strings::convertHexToBinaryString($version);
	}

	/**
	 * @param int $version
	 */
	public function setDecimalVersion($version) {
		$this->version = Strings::convertDecimalToBinaryString($version);
	}

	/**
	 * @return string as binary string
	 */
	public function getPayload() {
		return $this->version . $this->hash;
	}

	/**
	 * @return int
	 */
	public function getVersionLength() {
		return $this->versionLength;
	}

	/**
	 * @return int
	 */
	public function getHashLength() {
		return $this->hashLength;
	}

	/**
	 * @param int $versionLength
	 * @param int $hashLength
	 * @throws InvalidArgumentException
	 */
	public static function validateLengths($versionLength, $hashLength) {
		if ($versionLength < 1) {
			throw new InvalidArgumentException($versionLength . ' is invalid version length!');
		}
	
		if ($hashLength < 1) {
			throw new InvalidArgumentException($hashLength . ' is invalid hash length!');
		}
	}

}
