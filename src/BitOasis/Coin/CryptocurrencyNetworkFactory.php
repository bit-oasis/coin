<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidNetworkException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
interface CryptocurrencyNetworkFactory {

	/**
	 * @throws InvalidNetworkException
	 */
	public function create(string $code): CryptocurrencyNetwork;

}