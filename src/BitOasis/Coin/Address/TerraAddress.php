<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\TerraAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TerraAddress extends BaseBech32AddressWithTag implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @param $tag
	 * @return TerraAddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new TerraAddressValidator($address, $tag);
	}

	public function toString() {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public static function getClassAdditionalIdName() {
		return 'memo';
	}

}
