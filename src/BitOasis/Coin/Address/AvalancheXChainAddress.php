<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\AvalancheBech32AddressValidator;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class AvalancheXChainAddress extends BaseBech32AddressWithoutTag {

	public const PREFIX = 'X';

	protected function createValidator($address) {
		return new AvalancheBech32AddressValidator($address, null, self::PREFIX);
	}

}
