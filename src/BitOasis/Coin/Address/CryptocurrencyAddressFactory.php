<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
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
	 * @return CryptocurrencyAddress
	 * @throws InvalidCurrencyException
	 * @throws InvalidAddressException
	 */
	public function create($value, Cryptocurrency $currency) {
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
		if(!isset($this->types[$currency->getCode()])) {
			throw new InvalidCurrencyException('Address handler for currency ' . $currency->getCode() . ' not found!');
		}
		$cryptocurrencyAddressClass = $this->types[$currency->getCode()];
		return $cryptocurrencyAddressClass::deserialize($value, $currency);
	}

}
