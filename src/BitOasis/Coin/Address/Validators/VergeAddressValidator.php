<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class VergeAddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
        'D' => '1e',
    ];

}

