<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class DigibyteBase58AddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
		// Supporting only legacy addresses
        'D' => '1e',
		'S' => '3f'
    ];
}
