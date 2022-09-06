<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TerraAddressValidator extends Bech32AddressValidator implements ValidationInterface {

	public function __construct($address, $tag = null) {
		$this->prefix = 'terra';
		$this->bech32DecodedLengths = [32];
		$this->label = 'Terra';

		parent::__construct($address, $tag);
	}

}
