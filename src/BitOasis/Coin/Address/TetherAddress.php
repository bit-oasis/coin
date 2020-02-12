<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\Exception\InvalidAddressException;

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
	public function createUnderlyingProtocolAddress($address, Cryptocurrency $cryptocurrency) {
		try {
			$this->cryptocurrencyAddress = new EthereumAddress($address, $cryptocurrency);
		} catch (InvalidAddressException $e) {
		}
		if ($this->cryptocurrencyAddress === null) {
			throw new InvalidAddressException("$address is not valid/supported Tether address, only ECR20 layer is supported.");
		}
	}
}
