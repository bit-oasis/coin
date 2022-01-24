<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class TerraAddressValidator extends Bech32AddressWithPrefixValidator implements ValidationInterface {
	protected $prefix = 'terra';
	protected $bech32DecodedLength = 32;
	protected $label = 'Terra';
}
