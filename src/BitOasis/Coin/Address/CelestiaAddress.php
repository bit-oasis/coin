<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\CelestiaAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class CelestiaAddress extends BaseBech32AddressWithTag implements CryptocurrencyAddress {

	protected function createValidator($address, $tag = null): CelestiaAddressValidator {
		return new CelestiaAddressValidator($address, $tag);
	}

	public function toString(): string {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public static function getClassAdditionalIdName(): string {
		return 'memo';
	}
}