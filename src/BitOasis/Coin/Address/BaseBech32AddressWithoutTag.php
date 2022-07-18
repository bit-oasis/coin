<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\Bech32AddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

abstract class BaseBech32AddressWithoutTag implements CryptocurrencyAddress {

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
	public function __construct(string $address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$this->validateAddress($address);

		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
	}

	public function toString() {
		return $this->address;
	}

	/**
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork() {
		return $this->cryptocurrencyNetwork;
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
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return $this->address;
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @param string $address
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address) {
		return $this->createValidator($address)->validateWithExceptions();
	}

	/**
	 * @param $address
	 * @return Bech32AddressValidator
	 */
	protected abstract function createValidator($address);

}
