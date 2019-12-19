<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ETH as ETHValidator;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class EthereumClassicAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/**
	 * EthereumClassicAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency) {
		if(!$this->isValid($address)) {
			throw new InvalidAddressException('This is not valid ethereum classic address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
	}

	public function toString() {
	    return $this->address;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return $this->address;
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address;
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency) {
		return new static($string, $cryptocurrency);
	}

	/**
	 * @param $address
	 * @return bool
	 */
	private function isValid($address) {
		return (new ETHValidator($address))->validate();
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId() {
		return self::supportsClassAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return self::getAdditionalIdName() !== null;
	}

	/**
	 * @inheritDoc
	 */
	public static function getAdditionalIdName() {
		return null;
	}

}