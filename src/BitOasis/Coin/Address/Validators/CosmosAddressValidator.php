<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CosmosAddressValidator extends Bech32AddressValidator implements ValidationInterface {

	public function __construct($address, $tag = null) {
		$this->prefix = 'cosmos';
		$this->bech32DecodedLengths = [32];
		$this->label = 'Cosmos';

		parent::__construct($address, $tag);
	}

}
