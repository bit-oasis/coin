<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNetworkException;
use BitOasis\Coin\Exception\NetworkNotDefinedForCryptocurrency;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
interface ICryptocurrencyNetworkProvider {

	public function isCryptocurrencySupportingAnyNetwork(string $cryptocurrencyCode): bool;

	public function isCryptocurrencySupportingSpecificNetwork(string $cryptocurrencyCode, string $networkCode): bool;

	/**
	 * @throws NetworkNotDefinedForCryptocurrency
	 * @throws InvalidNetworkException
	 */
	public function getDefaultNetworkForCurrency(Cryptocurrency $cryptocurrency): CryptocurrencyNetwork;

	/**
	 * @throws NetworkNotDefinedForCryptocurrency
	 */
	public function getDefaultNetworkCodeForCurrencyCode(string $cryptocurrencyCode): string;

	/**
	 * @throws NetworkNotDefinedForCryptocurrency
	 */
	public function getNetworkCodesForCryptocurrency(Cryptocurrency $cryptocurrency): array;

}
