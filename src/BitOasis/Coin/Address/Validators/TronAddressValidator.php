<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TronAddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
        'T' => '41',
    ];

}
