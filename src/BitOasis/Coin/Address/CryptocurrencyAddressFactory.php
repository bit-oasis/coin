<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Network\CryptocurrencyNetwork;
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
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork|null $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 * @throws InvalidCurrencyException
	 */
	public function create($value, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		return $this->deserialize($value, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @param string $value
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 * @throws InvalidCurrencyException
	 */
	public function deserialize($value, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		if ($value === null) {
			return null;
		}
		if (!isset($this->types[$currency->getCode()])) {
			throw new InvalidCurrencyException('Address handler for currency ' . $currency->getCode() . ' not found!');
		}

		if (!isset($this->types[$currency->getCode()][$cryptocurrencyNetwork->getCode()])) {
			throw new InvalidCurrencyException('Address handler for ' . $currency->getCode() . ' network ' . $cryptocurrencyNetwork->getCode() . ' not found!');
		}

		/** @var CryptocurrencyAddress $cryptocurrencyAddressClass */
		$cryptocurrencyAddressClass = $this->types[$currency->getCode()][$cryptocurrencyNetwork->getCode()];
		return $cryptocurrencyAddressClass::deserialize($value, $currency, $cryptocurrencyNetwork);
	}

}
