<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\CosmosAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CosmosAddress extends BaseBech32WithPrefixAddress implements CryptocurrencyAddress {
	/**
	 * @param string $address
	 * @param $tag
	 * @return CosmosAddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new CosmosAddressValidator($address, $tag);
	}
}