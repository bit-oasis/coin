<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class NearAddressValidator implements ValidationInterface {

	/** Min length is 2 actually, but if you combine .near with at least 1 char, it will be 6 chars */
	const READABLE_ADDRESS_MIN_LENGTH = 6;

	/** Value including address domain for example strlen(test.near) = 9 */
	const READABLE_ADDRESS_MAX_LENGTH = 64;

	const READABLE_ADDRESS_AVAILABLE_DOMAINS = [
		'near',
	];

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		return $this->validateHexAddress() || $this->validateAccountReadableAddress();
	}

	private function validateAccountReadableAddress(): bool {
		$length = strlen($this->address);

		if ($length > self::READABLE_ADDRESS_MAX_LENGTH || $length < self::READABLE_ADDRESS_MIN_LENGTH) {
			return false;
		}

		$exploded = explode('.', $this->address);

		if (count($exploded) !== 2) {
			return false;
		}

		list($addressName, $addressDomain) = $exploded;

		if (!in_array($addressDomain, self::READABLE_ADDRESS_AVAILABLE_DOMAINS)) {
			return false;
		}

		if (preg_match('/^[a-zA-Z0-9]([a-zA-Z0-9_-]{0,1}[a-zA-Z0-9]+)*(?<!_|-)$/', $addressName) == 0) {
			return false;
		}

		return true;
	}

	private function validateHexAddress(): bool {
		if (preg_match('/^[a-fA-F0-9]{64}$/', $this->address) == 0) {
			return false;
		}

		return true;
	}
}