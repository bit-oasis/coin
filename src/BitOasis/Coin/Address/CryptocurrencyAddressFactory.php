<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Address\RippleAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class CryptocurrencyAddressFactory {

	/** @var CryptocurrencyAddress[] keys are currency codes */
	protected $types;

	/**
	 * CryptocurrencyAddressFactory constructor.
	 * @param CryptocurrencyAddress[] $types
	 */
	public function __construct(array $types) {
		$this->types = $types;
	}


	/**
	 * @param string $value
	 * @param Cryptocurrency $currency
	 * @param array $params other optional parameters
	 * @return CryptocurrencyAddress
	 * @throws InvalidCurrencyException
	 * @throws InvalidAddressException
	 */
	public function create($value, Cryptocurrency $currency) {
		if ($currency === Cryptocurrency::XRP) {
			$this->validateCryptocurrencyAddress($currency);
			$args = array_slice(func_get_args(), 0, 2);
			return new RippleAddress($value, $currency, count($args) > 0 ? $args[0] : null);
		}
		return $this->deserialize($value, $currency);
	}

	/**
	 * @param string $value
	 * @param Cryptocurrency $currency
	 * @return CryptocurrencyAddress
	 * @throws InvalidCurrencyException
	 * @throws InvalidAddressException
	 */
	public function deserialize($value, Cryptocurrency $currency) {
		if($value === null) {
			return null;
		}
		$this->validateCryptocurrencyAddress($currency);
	    $cryptocurrencyAddressClass = $this->types[$currency->getCode()];
	    return $cryptocurrencyAddressClass::deserialize($value, $currency);
	}

	/**
	 * @param Cryptocurrency $currency
	 * @return CryptocurrencyAddress
	 * @throws InvalidCurrencyException
	 */
	protected function validateCryptocurrencyAddress(Cryptocurrency $currency) {
		if(!isset($this->types[$currency->getCode()])) {
	    	throw new InvalidCurrencyException('Address handler for currency ' . $currency->getCode() . ' not found!');
	    }
	}

}