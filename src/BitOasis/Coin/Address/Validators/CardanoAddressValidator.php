<?php

namespace BitOasis\Coin\Address\Validators;

use BitOasis\Coin\Utils\Bech32\Bech32;
use BitOasis\Coin\Utils\Bech32\Bech32Exception;
use BitOasis\Coin\Utils\CBOR\Decoder;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use StephenHill\Base58;

/**
 * @author Robert Mkrtchyan <mkrtchyanrobert@gmail.com>
 * @original github.com
 * @see https://github.com/Merkeleon/php-cryptocurrency-address-validation/blob/master/src/Validation/ADA.php
 */
class CardanoAddressValidator implements ValidationInterface {

	protected $address;

	public function __construct($address) {
		$this->address = $address;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		$valid = $this->isValidV1($this->address);
		if (!$valid) {
			// maybe it's a bech32 address
			try {
				$valid = is_array($decoded = Bech32::decode($this->address)) && 'addr' === $decoded[0];
			} catch (Bech32Exception $exception) {
				$valid = false;
			}
		}

		return $valid;
	}

	public function isValidV1($address) {
		try {
			$base58 = new Base58();
			$addressBin = $base58->decode($address);

			$decoder = new Decoder();
			$object = $decoder->decode($addressBin);

			$normalizedData = $object->getNormalizedData();
			if ($object->getMajorType() != 4) {
				return false;
			}
			if (count($normalizedData) != 2) {
				return false;
			}
			if (!is_numeric($normalizedData[1])) {
				return false;
			}
			$crcCalculated = crc32($normalizedData[0]->getValue());
			$validCrc = $normalizedData[1];

			return $crcCalculated == (int)$validCrc;
		} catch (\Exception $e) {
			return false;
		}
	}
}