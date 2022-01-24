<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class CosmosAddressValidator extends Bech32AddressWithPrefixValidator implements ValidationInterface {
	protected $prefix = 'cosmos';
	protected $bech32DecodedLength = 32;
	protected $label = 'Cosmos';
}
