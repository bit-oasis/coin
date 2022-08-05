<?php

use BitOasis\Coin\Cryptocurrency;

use BitOasis\Coin\DefaultCryptocurrencyFactory;
use BitOasis\Coin\DefaultCryptocurrencyNetworkFactory;
use BitOasis\Coin\Exception\InvalidCurrencyException;
use BitOasis\Coin\Exception\InvalidNetworkException;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class UnitTestUtils {

	/**
	 * @param string $code
	 * @return Cryptocurrency
	 * @throws InvalidArgumentException
	 */
	public static function getCryptocurrency($code) {
		$factory = new DefaultCryptocurrencyFactory();
		try {
			return $factory->create($code);
		} catch (InvalidCurrencyException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

	/**
	 * @param string $code
	 * @return CryptocurrencyNetwork
	 * @throws InvalidArgumentException
	 */
	public static function getCryptocurrencyNetwork($code) {
		$factory = new DefaultCryptocurrencyNetworkFactory();
		try {
			return $factory->create($code);
		} catch (InvalidNetworkException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}

}
