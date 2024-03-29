<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
abstract class BaseMultiProtocolAddress implements CryptocurrencyAddress {

	/** @var CryptocurrencyAddress */
	protected $cryptocurrencyAddress;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * @param $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$this->currency = $currency;
		$this->createUnderlyingProtocolAddress($address, $currency, $cryptocurrencyNetwork);
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
	public function getNetwork() {
		return $this->cryptocurrencyAddress->getNetwork();
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
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @return bool
	 */
	public function isEthereumAddress() {
		return $this->cryptocurrencyAddress instanceof EthereumAddress;
	}

	/**
	 * @param $address
	 * @param Cryptocurrency $cryptocurrency
	 * @throws InvalidAddressException
	 */
	abstract public function createUnderlyingProtocolAddress($address, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork);
}
