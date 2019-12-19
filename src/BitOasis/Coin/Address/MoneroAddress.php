<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Address\Validators\MoneroAddressValidator;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class MoneroAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var string|null */
	protected $paymentId;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param string $paymentId
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $paymentId = null) {
		$this->validate($address, $paymentId);
		
		$this->address = $address;
		$this->currency = $currency;
		$this->paymentId = $paymentId;
	}

	/**
	 * @return string
	 */
	public function toString() {
		return 'Address: ' . $this->address . ($this->paymentId === null ? '' : (', Payment ID: ' . $this->paymentId));
	}

	/**
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return $this->getPaymentId();
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId() {
		return self::supportsClassAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return self::getAdditionalIdName() !== null;
	}

	/**
	 * @inheritDoc
	 */
	public static function getAdditionalIdName() {
		return 'paymentId';
	}

	/**
	 * @return string|null
	 */
	public function getPaymentId() {
		return $this->paymentId;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return self::serializeAddress($this->address, $this->paymentId);
	}

	/**
	 * @param string $address
	 * @param string|null $paymentId
	 * @return string
	 */
	public static function serializeAddress($address, $paymentId = null) {
		return $address . ($paymentId === null ? '' : ('#' . $paymentId));
	}

	/**
	 * @param string $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return \static
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		$addressParts = explode('#', $string);
		return new static($addressParts[0], $cryptocurrency, isset($addressParts[1]) ? $addressParts[1] : null);
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->paymentId === $address->paymentId;
	}

	/**
	 * @return bool
	 */
	public function isBaseAddress() {
		return $this->createValidator($this->address, $this->paymentId)
			->isBaseAddress();
	}

	/**
	 * @return bool
	 */
	public function isIntegratedAddress() {
		return $this->createValidator($this->address, $this->paymentId)
			->isIntegratedAddress();
	}

	/**
	 * @param string $address
	 * @param $paymentId
	 * @return bool
	 */
	private function isValid($address, $paymentId = null) {
		return $this->createValidator($address, $paymentId)
			->validate();
	}

	/**
	 * @param string $address
	 * @param $paymentId
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validate($address, $paymentId = null) {
		return $this->createValidator($address, $paymentId)
			->validateWithExceptions();
	}

	/**
	 * @param string $address
	 * @param $paymentId
	 * @return MoneroAddressValidator
	 */
	private function createValidator($address, $paymentId = null) {
		return new MoneroAddressValidator($address, $paymentId);
	}

}
