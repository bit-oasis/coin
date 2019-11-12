<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use Nette\NotImplementedException;

class TetherAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var CryptocurrencyAddress */
	protected $cryptocurrencyAddress;

	public function __construct($address) {
		$this->validateAddress($address);
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
		throw new NotImplementedException();
	}

	/**
	 * @param $address
	 * @throws InvalidAddressException
	 */
	public function validateAddress($address) {
		if ($this->isEthereumAddress($address)) {
			$this->cryptocurrencyAddress = $this->createEthereumAddress($address);
		}
		throw new InvalidAddressException("Address '{$address}' is not valid for Tether");
	}

	/**
	 * @param string $address
	 * @return EthereumAddress
	 * @throws InvalidAddressException
	 */
	protected function createEthereumAddress($address) {
		return new EthereumAddress($address, new Cryptocurrency(Cryptocurrency::ETH, 18, 'Ethereum'));
	}

	/**
	 * @param $address
	 * @return bool
	 */
	public function isEthereumAddress($address) {
		try {
			$this->createEthereumAddress($address);
			return true;
		} catch (InvalidAddressException $e) {
			return false;
		}
	}

}
