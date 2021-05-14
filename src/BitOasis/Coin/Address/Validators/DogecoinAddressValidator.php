<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class DogecoinAddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
        'D' => '1e',
        'A' => '16',
        '9' => '16',
    ];
}
