<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\AlgorandAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
class AlgorandAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$this->validateAddress($address);
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
	}

	/**
	 * @inheritDoc
	 */
	public function toString() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId() {
		return static::supportsClassAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalIdName() {
		return static::getClassAdditionalIdName();
	}

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @inheritDoc
	 */
	public function getNetwork() {
		return $this->cryptocurrencyNetwork;
	}

	/**
	 * @inheritDoc
	 */
	public function serialize() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @inheritDoc
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @param string $address
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address) {
		$validator = new AlgorandAddressValidator($address);
		$validator->validateWithExceptions();
	}

}
