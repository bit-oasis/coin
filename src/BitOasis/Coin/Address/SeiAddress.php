<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\SeiAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class SeiAddress extends BaseBech32AddressWithTag implements CryptocurrencyAddress {

	/**
	 * @param $address
	 * @param null $tag
	 * @return SeiAddressValidator
	 */
	protected function createValidator($address, $tag = null): SeiAddressValidator {
		return new SeiAddressValidator($address, $tag);
	}

	public function toString(): string {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public static function getClassAdditionalIdName(): string {
		return 'memo';
	}
}