<?php

namespace BitOasis\Coin\Network;

use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
interface CryptocurrencyNetworkFactory {

	/**
	 * @param $code
	 * @return CryptocurrencyNetwork
	 * @throws InvalidCurrencyException
	 */
	public function create($code);

}