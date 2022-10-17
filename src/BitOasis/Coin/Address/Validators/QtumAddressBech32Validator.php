<?php

namespace BitOasis\Coin\Address\Validators;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class QtumAddressBech32Validator extends Bech32AddressValidator {

	public function __construct($address, $tag = null) {
		$this->prefix = 'qc';
		$this->bech32DecodedLengths = [53];
		$this->label = 'QTUM';

		parent::__construct($address, $tag);
	}

}
