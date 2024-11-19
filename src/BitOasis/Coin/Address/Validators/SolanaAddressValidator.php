<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use StephenHill\Base58;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class SolanaAddressValidator implements ValidationInterface {

	const HEX_BYTE_LENGTH = 32;

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		try {
			$base58 = new Base58();
			$binaryDecoded = $base58->decode($this->address);
			$hexDecoded = bin2hex($binaryDecoded);

			if (!\ctype_xdigit($hexDecoded) || strlen($hexDecoded) % 2 !== 0 || strlen($binaryDecoded) !== self::HEX_BYTE_LENGTH) {
				return false;
			}

			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
}