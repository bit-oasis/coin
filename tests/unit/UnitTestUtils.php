<?php

use BitOasis\Coin\Cryptocurrency;

use BitOasis\Coin\DefaultCryptocurrencyFactory;
use BitOasis\Coin\Exception\InvalidCurrencyException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class UnitTestUtils {

	/**
	 * @param string $code
	 * @return Cryptocurrency
	 * @throws \InvalidArgumentException
	 */
	public static function getCryptocurrency($code) {
		$factory = new DefaultCryptocurrencyFactory();
		try {
			return $factory->create($code);
		} catch (InvalidCurrencyException $e) {
			throw new \InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

}
