<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Shawki.Alassi <shawki.alassi@bitoasis.net>
 */
class SonicAddressValidator implements ValidationInterface {

	/** @var string */
	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @inheritDoc
	 */
	public function validate(): bool {
		return preg_match('/^(0x)?[0-9a-f]{40}$/i', $this->address);
	}
}