<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\SeiAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SeiAddress extends BaseBech32AddressWithoutTag implements CryptocurrencyAddress {

	/**
	 * @param $address
	 * @return SeiAddressValidator
	 */
	protected function createValidator($address): SeiAddressValidator {
		return new SeiAddressValidator($address);
	}
}