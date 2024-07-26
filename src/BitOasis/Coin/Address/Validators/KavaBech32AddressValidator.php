<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author ahmad.yousef <ahmad.yousef@bitoasis.net>
 */
class KavaBech32AddressValidator extends Bech32AddressValidator implements ValidationInterface {

	public function __construct($address, $tag = null) {
		$this->prefix = 'kava';
		$this->bech32DecodedLengths = [32];
		$this->label = 'kava';

		parent::__construct($address, $tag);
	}

}