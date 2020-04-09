<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class NeoAddressValidator extends Validation {

	protected $base58PrefixToHexVersion = [
		'A' => '17',
	];

}
