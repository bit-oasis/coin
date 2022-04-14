<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class IotaAddressValidator extends Bech32AddressValidator implements ValidationInterface {

	protected $prefix = 'iota';
	protected $bech32DecodedLength = 53;
	protected $label = 'Iota';

}
