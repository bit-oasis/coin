<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class PolkadotAddressValidator extends SS58AddressValidator implements ValidationInterface {

	protected $allowedPrefixes = [
		1
	];

}
