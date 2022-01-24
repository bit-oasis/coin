<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class NearAddressValidator implements ValidationInterface {

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		if (preg_match('/^[a-f0-9]{64}$/', $this->address) == 0) {
			return false;
		}

		return true;
	}
}