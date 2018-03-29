<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\LTC;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddressValidator extends LTC {

	protected $base58PrefixToHexVersion = [
		'L' => '30',
		'M' => '32',
		'3' => self::DEPRECATED_ADDRESS_VERSION // deprecated for litecoin, should not be allowed for new user's inputs
	];

}