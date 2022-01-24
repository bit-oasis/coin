<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use StephenHill\Base58;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class SolanaAddressValidator implements ValidationInterface {

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

			if (!\ctype_xdigit($hexDecoded) || strlen($hexDecoded) % 2 !== 0) {
				return false;
			}

			sodium_crypto_sign_ed25519_pk_to_curve25519($binaryDecoded);

			return true;
		} catch (\SodiumException $e) {
		} catch (\InvalidArgumentException $e) {
		} catch (\Exception $e) {
		}

		return false;
	}
}