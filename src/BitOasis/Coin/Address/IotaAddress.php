<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\IotaAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class IotaAddress extends BaseBech32Address implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @param $tag
	 * @return IotaAddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new IotaAddressValidator($address);
	}

}
