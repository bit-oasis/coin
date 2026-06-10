<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Address\Validators\WavesAddressValidator;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class WavesAddress implements CryptocurrencyAddress {

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
		$this->validate($address);

		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork() {
		return $this->cryptocurrencyNetwork;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return $this->address;
	}

	/**
	 * @return string
	 */
	public function toString() {
		return $this->address;
	}

	/**
	 * @param string $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return static
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
	private function validate($address) {
		return $this->createValidator($address)
			->validateWithExceptions();
	}

	/**
	 * @param string $address
	 * @return WavesAddressValidator
	 */
	private function createValidator($address) {
		return new WavesAddressValidator($address);
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
}
