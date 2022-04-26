<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ElrondEgoldValidator extends Bech32AddressValidator implements ValidationInterface {

	public function __construct($address, $tag = null) {
		$this->prefix = 'erd';
		$this->bech32DecodedLength = 52;
		$this->label = 'Elrond eGold';

		parent::__construct($address, $tag);
	}

}
