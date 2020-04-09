<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation;
use function strlen;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class TezosAddressValidator extends Validation {

	protected $length = 54;
	protected $base58PrefixToHexVersion = [
		'tz1' => '06A19F',
		'tz2' => '06A1A1',
		'tz3' => '06A1A4',
		'KT' => '025A79',
	];

	protected function determineVersion() {
		foreach ($this->base58PrefixToHexVersion as $prefix => $hex) {
			if (\strpos($this->address, $prefix) === 0) {
				$this->addressVersion = $hex;
				return;
			}
		}
	}

	public function validate() {
		if ($this->addressVersion === null) {
			return false;
		}

		$hexAddress = self::base58ToHex($this->address);

		if (strlen($hexAddress) !== $this->length) {
			return false;
		}
		$version = substr($hexAddress, 0, 6);

		if (!$this->validateVersion($version)) {
			return false;
		}

		$check = substr($hexAddress, 0, -8);
		$check = pack('H*', $check);
		$check = strtoupper(hash('sha256', hash('sha256', $check, true)));
		$check = substr($check, 0, 8);
		return $check === substr($hexAddress, -8);
	}

}
