<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Address\Validators\LitecoinAddressValidator;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * BitcoinAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $oldFormatAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $oldFormatAllowed = true) {
		if(!$this->isValid($address, $oldFormatAllowed)) {
			throw new InvalidAddressException('This is not valid litecoin address - ' . $address);
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
	 * @param bool $oldFormatAllowed
	 * @return bool
	 */
	private function isValid($address, $oldFormatAllowed = true) {
		$validator = new LitecoinAddressValidator($address);
		$validator->setDeprecatedAllowed($oldFormatAllowed);
		return $validator->validate();
	}

}