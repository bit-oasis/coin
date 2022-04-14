<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class ElrondEgoldValidator extends Bech32AddressValidator implements ValidationInterface {

	protected $prefix = 'erd';
	protected $bech32DecodedLength = 52;
	protected $label = 'Elrond eGold';

}
