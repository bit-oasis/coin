<?php

namespace BitOasis\Coin\Address;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class LeoAddress extends BaseMultiProtocolAddress {

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return false;
	}

	/**
	 * LEO does not utilize additional ID since Ethereum address
	 * is the only valid as underlying protocols addresses so far
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
