<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class BitcoinGoldAddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
		'A' => '17',
		'G' => '26'
	];

}
