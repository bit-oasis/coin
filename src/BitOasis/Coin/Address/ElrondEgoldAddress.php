<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\ElrondEgoldValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ElrondEgoldAddress extends BaseBech32Address implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @param $tag
	 * @return ElrondEgoldValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new ElrondEgoldValidator($address, $tag);
	}

}
