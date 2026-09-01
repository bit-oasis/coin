<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

class PolygonAddressValidator implements ValidationInterface {

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	public function validate() {
		return preg_match('/^(0x)?[0-9a-f]{40}$/i', $this->address);
	}

}