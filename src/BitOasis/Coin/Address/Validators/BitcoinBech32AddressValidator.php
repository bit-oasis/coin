<?php

namespace BitOasis\Coin\Address\Validators;

class BitcoinBech32AddressValidator extends Bech32AddressValidator {

	public function __construct($address, $tag = null) {
		$this->prefix = 'bc';
		$this->bech32DecodedLengths = [33, 53];
		$this->label = 'Bitcoin';

		parent::__construct($address, $tag);
	}

}
