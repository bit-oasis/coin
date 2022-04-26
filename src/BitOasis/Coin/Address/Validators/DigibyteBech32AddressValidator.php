<?php

namespace BitOasis\Coin\Address\Validators;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class DigibyteBech32AddressValidator extends Bech32AddressValidator {

	public function __construct($address, $tag = null) {
		$this->prefix = 'dgb';
		$this->bech32DecodedLength = 33;
		$this->label = 'Digibyte';

		parent::__construct($address, $tag);
	}

}
