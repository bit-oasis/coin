<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Network\CryptocurrencyNetwork;

class TetherAddress extends BaseMultiProtocolAddress {

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return false;
	}

	/**
	 * Tether does not utilize additional ID since Bitcoin or Ethereum addresses
	 * are the only valid as underlying protocols addresses so far
	 *
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function createUnderlyingProtocolAddress($address, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		try {
			$this->cryptocurrencyAddress = new EthereumAddress($address, $cryptocurrency, $cryptocurrencyNetwork);
		} catch (InvalidAddressException $e) {
		}
		if ($this->cryptocurrencyAddress === null) {
			throw new InvalidAddressException("$address is not valid/supported Tether address, only ECR20 layer is supported.");
		}
	}
}
