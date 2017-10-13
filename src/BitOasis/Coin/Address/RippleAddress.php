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

	/** @var int should be unsigned 32b value */
	protected $tag;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param $tag
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $tag = null) {
		if (!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid ripple address - ' . $address);
		}
		$this->address = $address;
		$this->tag = $tag == '' || $tag < 0 ? null : (int)$tag;
		$this->currency = $currency;
	}

	public function toString() {
		$value = "Address: $this->address";
		if ($this->tag !== null) {
			$value .= ", Tag: $this->tag";
		}
		return $value;
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function serialize() {
		return $this->address . ($this->tag !== null ? "#$this->tag" : '');
	}

	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->tag === $address->tag;
	}

	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		@list($address, $tag) = explode('#', $string);
		return new static($address, $cryptocurrency, $tag);
	}

	private function isValid($address) {
		return Strings::match($address, '/^r[1-9A-HJ-NP-Za-km-z]{25,34}$/');
	}

}
