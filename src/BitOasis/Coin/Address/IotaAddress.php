<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\IotaAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class IotaAddress extends BaseBech32AddressWithoutTag implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @return IotaAddressValidator
	 */
	protected function createValidator($address) {
		return new IotaAddressValidator($address);
	}

}
