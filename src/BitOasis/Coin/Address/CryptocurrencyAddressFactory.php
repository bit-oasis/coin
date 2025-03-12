<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
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
	 * @throws InvalidAddressException
	 * @throws InvalidCurrencyException
	 */
	public function create(?string $value, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork): ?CryptocurrencyAddress {
		return $this->deserialize($value, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @throws InvalidAddressException
	 * @throws InvalidCurrencyException
	 */
	public function deserialize(?string $value, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork): ?CryptocurrencyAddress {
		if ($value === null) {
			return null;
		}

		if (!isset($this->types[$currency->getCode()])) {
			throw new InvalidCurrencyException('Address handler for currency ' . $currency->getCode() . ' not found!');
		}

		if (!isset($this->types[$cryptocurrencyNetwork->getCode()])) {
			throw new InvalidCurrencyException('Address handler for network ' . $cryptocurrencyNetwork->getCode() . ' not found!');
		}

		$cryptocurrencyAddressClass = $this->types[$cryptocurrencyNetwork->getCode()];
		return $cryptocurrencyAddressClass::deserialize($value, $currency, $cryptocurrencyNetwork);
	}

}
