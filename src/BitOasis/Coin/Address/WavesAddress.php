<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Address\Validators\WavesAddressValidator;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class WavesAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency) {
		$this->validate($address);

		$this->address = $address;
		$this->currency = $currency;
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
	 * @return \static
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
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
