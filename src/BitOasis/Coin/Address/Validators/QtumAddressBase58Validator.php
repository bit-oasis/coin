<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class QtumAddressBase58Validator extends Validation {

	protected $base58PrefixToHexVersion = [
        'Q' => '3a',
        'M' => '32',
    ];
}
