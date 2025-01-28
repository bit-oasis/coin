<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class InjectiveBech32AddressValidator extends Bech32AddressValidator implements ValidationInterface {

	public function __construct($address, $tag = null) {
		$this->prefix = 'inj';
		$this->bech32DecodedLengths = [32];
		$this->label = 'inj';

		parent::__construct($address, $tag);
	}
}