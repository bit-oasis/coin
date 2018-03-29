<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Address\Validators\BitcoinCashAddressValidator;

/**
 * @author David Fiedor <davefu@seznam.cz>
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class BitcoinCashAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * BitcoinCashAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $cashAddressAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $cashAddressAllowed = true) {
		$this->validateAddress($address, $cashAddressAllowed);
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
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 */
	private function isValid($address, $cashAddressAllowed = true) {
		$validator = new BitcoinCashAddressValidator($address);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		return $validator->validate();
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address, $cashAddressAllowed = true) {
		$validator = new BitcoinCashAddressValidator($address);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		return $validator->validateWithExceptions();
	}

}