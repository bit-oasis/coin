<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use Nette\Utils\Strings;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class RippleAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	public function __construct($address, Cryptocurrency $currency) {
		if (!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid ripple address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
	}

	public function toString() {
		return $this->address;
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function serialize() {
		return $this->address;
	}

	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	private function isValid($address) {
		return Strings::match($address, '/^r[1-9A-HJ-NP-Za-km-z]{25,34}$/');
	}

}
