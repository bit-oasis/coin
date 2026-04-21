<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class NeoV3AddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
		'N' => '35',
	];

}
