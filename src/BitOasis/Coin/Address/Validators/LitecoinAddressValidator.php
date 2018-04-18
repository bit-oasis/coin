<?php

namespace BitOasis\Coin\Address\Validators;

use Murich\PhpCryptocurrencyAddressValidation\Validation\LTC;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddressValidator extends LTC {
	
	const P2SH_ADDRESS_VERSION = '32';

	protected $base58PrefixToHexVersion = [
		'L' => '30',
		'M' => self::P2SH_ADDRESS_VERSION,
		'3' => self::DEPRECATED_ADDRESS_VERSION // deprecated for litecoin, should not be allowed for new user's inputs
	];

	/**
	 * @return bool
	 */
	public function isDeprecatedP2shAddress() {
		return $this->addressVersion === self::DEPRECATED_ADDRESS_VERSION;
	}

	/**
	 * @return bool
	 */
	public function isP2shAddress() {
		return $this->addressVersion === self::P2SH_ADDRESS_VERSION;
	}

}