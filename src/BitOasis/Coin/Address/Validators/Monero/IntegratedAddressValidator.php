<?php

namespace BitOasis\Coin\Address\Validators\Monero;

use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class IntegratedAddressValidator extends AddressValidatorAdapter {

	/** @var array */
	protected $base58PrefixToHexVersion = ['4' => '13'];

	protected function validatePaymentId() {
		if ($this->paymentId !== null) {
			throw new InvalidAddressException('Integrated address does not have separate payment ID!');
		}
		return true;
	}

}
