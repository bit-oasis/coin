<?php

namespace BitOasis\Coin\Utils\CryptoNote;

use BitOasis\Coin\Utils\Strings;
use BitOasis\Coin\Utils\Exception\InvalidArgumentException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class CryptoNoteDecodedAddress {

	/** @var int[] payload lengths without checksum */
	protected static $payloadLengths = [
		65,//single address
		73,//integrated address
	];

	/** @var string as binary string */
	protected $spendKey;

	/** @var string as binary string */
	protected $viewKey;

	/** @var string as binary string */
	protected $version;

	/** @var string as binary string */
	protected $paymentId;

	/**
	 * @param string $spendKey as binary string (public spend key)
	 * @param string $viewKey as binary string (public view key)
	 * @param string $version as binary string
	 * @param string $paymentId as binary string
	 * @throws InvalidArgumentException
	 */
	public function __construct($spendKey, $viewKey, $version, $paymentId = null) {
		$this->spendKey = $spendKey;
		$this->viewKey = $viewKey;
		$this->version = $version;
		$this->paymentId = $paymentId == '' ? null : $paymentId;
	}

	/**
	 * @param string $payload as binary string
	 * @return \static
	 * @throws InvalidArgumentException
	 */
	public static function fromPayload($payload) {
		if (!in_array(strlen($payload), self::$payloadLengths)) {
			throw new InvalidArgumentException('Invalid payload length!');
		}
		
		return new static(substr($payload, 1, 32), substr($payload, 33, 32), substr($payload, 0, 1), substr($payload, 65, 8));
	}

	/**
	 * Public spend key
	 * @return string as binary string
	 */
	public function getSpendKey() {
		return $this->spendKey;
	}

	/**
	 * Public view key
	 * @return string as binary string
	 */
	public function getViewKey() {
		return $this->viewKey;
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
	 * @return null|string as binery string
	 */
	public function getPaymentId() {
		return $this->paymentId;
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
		return $this->version . $this->spendKey . $this->viewKey . $this->paymentId;
	}

}
