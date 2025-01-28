<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\InjectiveBech32AddressValidator;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class InjectiveAddress extends BaseBech32AddressWithTag {

	/**
	 * @param string $address
	 * @param $tag
	 * @return InjectiveBech32AddressValidator
	 */
	protected function createValidator($address, $tag = null) {
		return new InjectiveBech32AddressValidator($address, $tag);
	}

	public function toString() {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Memo: ' . $this->tag));
	}

	public static function getClassAdditionalIdName() {
		return 'memo';
	}
}