<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
interface CryptocurrencyFactory {

	/**
	 * @param $code
	 * @return Cryptocurrency
	 * @throws InvalidCurrencyException
	 */
	public function create($code);

}