<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;

class TetherAddress implements CryptocurrencyAddress {

	/** @var CryptocurrencyAddress */
	protected $cryptocurrencyAddress;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * @param $address
	 * @param Cryptocurrency $currency
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency) {
		$this->currency = $currency;
		$this->createUnderlyingProtocolAddress($address, $currency);
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress() {
		return $this->cryptocurrencyAddress->getAddress();
	}

	/**
	 * @inheritDoc
	 */
	public function toString() {
		return $this->cryptocurrencyAddress->toString();
	}

	/**
	 * @inheritDoc
	 */
	public function serialize() {
		return $this->cryptocurrencyAddress->serialize();
	}

	/**
	 * @inheritDoc
	 */
	public function getCurrency() {
		return $this->cryptocurrencyAddress->getCurrency();
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId() {
		return $this->cryptocurrencyAddress->supportsAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalIdName() {
		return $this->cryptocurrencyAddress->getAdditionalIdName();
	}

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
	public function getAdditionalId() {
		return $this->cryptocurrencyAddress->getAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $this->cryptocurrencyAddress->equals($address);
	}

	/**
	 * @inheritDoc
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	/**
	 * @param $address
	 * @param Cryptocurrency $cryptocurrency
	 * @throws InvalidAddressException
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

	/**
	 * @return bool
	 */
	public function isEthereumAddress() {
		return $this->cryptocurrencyAddress instanceof EthereumAddress;
	}

}
