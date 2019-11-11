<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;

/**
 * @author Stanislav Fukala <stanislav.fukala@gmail.com>
 */
class BasicAttentionTokenAddress extends EthereumAddress {

	/**
	 * @param string $address
	 * @param Cryptocurrency$currency
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency) {
		if (!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid basic attention token address - ' . $address);
		}
		parent::__construct($address, $currency);
	}

}
