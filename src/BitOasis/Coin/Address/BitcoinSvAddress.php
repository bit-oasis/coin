<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Address\Validators\BitcoinSvAddressValidator;

/**
 * Bitcoin SV (Satoshi Vision) address
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinSvAddress extends BaseBitcoinCashAddress {

	/**
	 * BitcoinSvAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $cashAddressAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $cashAddressAllowed = true) {
		if ($currency->getCode() !== Cryptocurrency::BSV) {
			throw new InvalidAddressException($currency->getCode() . ' is not valid currency for Bitcoin SV address!');
		}
		parent::__construct($address, $currency, $cashAddressAllowed);
	}

	/**
	 * @inheritDoc
	 */
	protected function createValidator($address, $cashAddressAllowed = true) {
		$validator = new BitcoinSvAddressValidator($address);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		return $validator;
	}

}
