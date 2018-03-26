<?php

namespace BitOasis\Coin\Address;

use Murich\PhpCryptocurrencyAddressValidation\Validation\LTC;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddressValidator extends LTC {

	public function validate() {
		$this->base58PrefixToHexVersion['M'] = '32';
		return parent::validate();
	}

}