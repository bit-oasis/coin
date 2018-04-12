<?php

namespace BitOasis\Coin\Utils;

use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class Base58DecodedAddress {

	/** @var string as binary string */
	protected $hash;

	/** @var string as binary string */
	protected $version;

	/**
	 * @param string $hash as binary string
	 * @param string $version as binary string
	 */
	public function __construct($hash, $version) {
		$this->hash = $hash;
		$this->version = $version;
	}

	/**
	 * @param string $payload as binery string
	 * @return \static
	 * @throws InvalidArgumentException
	 */
	public static function fromPayload($payload) {
		if (strlen($payload) !== 21) {
			throw new InvalidArgumentException('Invalid payload length!');
		}
		
		return new static(substr($payload, 1), substr($payload, 0, 1));
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
		return Base58Check::convertBinaryStringToHex($this->version);
	}

	/**
	 * @return int
	 */
	public function getDecimalVersion() {
		return Base58Check::convertBinaryStringToDecimal($this->version);
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
		$this->version = Base58Check::convertHexToBinaryString($version);
	}

	/**
	 * @param int $version
	 */
	public function setDecimalVersion($version) {
		$this->version = Base58Check::convertDecimalToBinaryString($version);
	}

	/**
	 * @return string as binary string
	 */
	public function getPayload() {
		return $this->version . $this->hash;
	}

}
