<?php

namespace BitOasis\Coin\Address\Validators\Monero;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BaseAddressValidator extends AddressValidatorAdapter {

	/** @var array */
	protected $base58PrefixToHexVersion = ['4' => '12'];

}
