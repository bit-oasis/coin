<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\QtumAddressBase58Validator;
use BitOasis\Coin\Address\Validators\QtumAddressBech32Validator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class QtumAddress implements CryptocurrencyAddress {

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
		if(!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid QTUM address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
	}

	public function toString() {
		return $this->address;
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
	 * @param string $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	/**
	 * @param string $address
	 * @return bool
	 */
	private function isValid($address) {
		$base58Validator = new QtumAddressBase58Validator($address);
		$bech32Validator = new QtumAddressBech32Validator($address);

		if ($base58Validator->validate()) {
			// If it is valid base58 address
			return true;
		}

		if ($bech32Validator->validate()) {
			// If it is valid bech32 address
			return true;
		}

		return false;
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
