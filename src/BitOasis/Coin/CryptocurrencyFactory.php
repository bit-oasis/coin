<?php

namespace BitOasis\Coin;

use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
interface CryptocurrencyFactory {

	/**
	 * @throws InvalidCurrencyException
	 */
	public function create(string $code): Cryptocurrency;

}