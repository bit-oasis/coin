<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\TerraAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TerraAddress extends BaseBech32AddressWithPrefixAndTag implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @param $tag
	 * @return TerraAddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new TerraAddressValidator($address, $tag);
	}
}