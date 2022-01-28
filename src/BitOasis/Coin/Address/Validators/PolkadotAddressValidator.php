<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Exception\InvalidArgumentException;
use BitOasis\Coin\Utils\Exception\InvalidChecksumException;
use BitOasis\Coin\Utils\Strings;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use StephenHill\Base58;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 */
class PolkadotAddressValidator implements ValidationInterface {

	const SUBSTRATE_PREFIX = 'SS58PRE';
	const CHECKSUM_LENGTH = 2;

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		try {
			$this->validateWithExceptions();
			return true;
		} catch (InvalidChecksumException $e) {
			return false;
		} catch (InvalidArgumentException $e) {
			return false;
		}
	}

	/**
	 * @throws InvalidChecksumException
	 * @throws InvalidArgumentException
	 */
	protected function validateWithExceptions() {
		try {
			$base58 = new Base58();
			$decodedValue = $base58->decode($this->address);

			if ($decodedValue[0] !== "\x00") {
				throw new InvalidArgumentException("Polkadot address should start with 1");
			}

			$payload =  self::SUBSTRATE_PREFIX . substr($decodedValue, 0, 0 - self::CHECKSUM_LENGTH);

			$checksum = Strings::convertBinaryStringToDecimal(substr($decodedValue, 0 - self::CHECKSUM_LENGTH), true);
			$newChecksum = Strings::convertBinaryStringToDecimal(Strings::blake2b512($payload), true);

			for ($i = 1; $i <= self::CHECKSUM_LENGTH; $i++) {
				if ($checksum[$i] !== $newChecksum[$i]) {
					throw new InvalidChecksumException('Invalid checksum!');
				}
			}
		} catch (\InvalidArgumentException $e) {
			throw new InvalidArgumentException($e->getMessage(), 0, $e);
		}
	}
}