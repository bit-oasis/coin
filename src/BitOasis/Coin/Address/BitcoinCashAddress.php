<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Address\Validators\BitcoinCashAddressValidator;
use BitOasis\Coin\MultiFormatAddress;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * Bitcoin Cash (Bitcoin ABC) address
 * @author David Fiedor <davefu@seznam.cz>
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class BitcoinCashAddress extends BaseBitcoinCashAddress implements MultiFormatAddress {

	/**
	 * BitcoinCashAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param bool $cashAddressAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $cashAddressAllowed = true) {
		if ($currency->getCode() !== Cryptocurrency::BCH) {
			throw new InvalidAddressException($currency->getCode() . ' is not valid currency for Bitcoin Cash address!');
		}
		parent::__construct($address, $currency, $cryptocurrencyNetwork, $cashAddressAllowed);
	}

	/**
	 * @inheritDoc
	 */
	protected function createValidator($address, $cashAddressAllowed = true) {
		$validator = new BitcoinCashAddressValidator($address);
		$validator->setCashAddressAllowed($cashAddressAllowed);
		return $validator;
	}

	/**
	 * @inheritDoc
	 */
	public function getOldFormatAddress() {
		return $this->toBase58()->getAddress();
	}

	/**
	 * @inheritDoc
	 */
	public function getNewFormatAddress() {
		return $this->toCashAddress()->getAddress();
	}

}
