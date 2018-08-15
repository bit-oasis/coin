<?php

use BitOasis\Coin\Cryptocurrency;

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
		switch($code) {
			case Cryptocurrency::BTC:
				return new Cryptocurrency($code, 8, 'Bitcoin');
			case Cryptocurrency::BCH:
				return new Cryptocurrency($code, 8, 'Bitcoin Cash');
			case Cryptocurrency::LTC:
				return new Cryptocurrency($code, 8, 'Litecoin');
			case Cryptocurrency::ETH:
				return new Cryptocurrency($code, 18, 'Ethereum');
			case Cryptocurrency::XRP:
				return new Cryptocurrency($code, 6, 'Ripple');
			case Cryptocurrency::XLM:
				return new Cryptocurrency($code, 7, 'Stellar Lumen');
			default:
				throw new \InvalidArgumentException("'$code' is not supported!");
		}
	}

}
