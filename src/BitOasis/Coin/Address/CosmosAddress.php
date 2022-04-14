<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\CosmosAddressValidator;
use BitOasis\Coin\CryptocurrencyAddress;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CosmosAddress extends BaseBech32Address implements CryptocurrencyAddress {

	/**
	 * @param string $address
	 * @param $tag
	 * @return CosmosAddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new CosmosAddressValidator($address, $tag);
	}

	public function toString() {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public static function getClassAdditionalIdName() {
		return 'memo';
	}

}
