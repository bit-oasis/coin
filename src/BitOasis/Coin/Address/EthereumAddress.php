<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use Nette\Utils\Strings;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class EthereumAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * EthereumAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency) {
		if(!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid ethereum address - ' . $address);
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
	 * @return bool
	 */
	private function isValid($address) {
		if (!Strings::match($address, '/^(0x)?[0-9a-fA-F]{40}$/')) {
			return false;
		} else if (Strings::match($address, '/^(0x)?[0-9a-f]{40}$/') || Strings::match($address, '/^(0x)?[0-9A-F]{40}$/')) {
			return true;
		} else {
			// todo:
			return true;
		}
	}

}