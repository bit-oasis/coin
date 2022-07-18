<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\Bech32AddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

abstract class BaseBech32AddressWithTag implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var int|string|null */
	protected $tag;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/**
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param int|string|null $tag
	 * @throws InvalidAddressException
	 */
	public function __construct(string $address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $tag = null) {
		$this->validateAddress($address, $tag);

		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
		$this->tag = $tag === null ? null : $tag;
	}

	public function toString() {
		return 'Address: ' . $this->address . ($this->tag === null ? '' : (', Tag: ' . $this->tag));
	}

	/**
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalId() {
		return $this->getTag();
	}

	/**
	 * @inheritDoc
	 */
	public function supportsAdditionalId() {
		return static::supportsClassAdditionalId();
	}

	/**
	 * @inheritDoc
	 */
	public function getAdditionalIdName() {
		return static::getClassAdditionalIdName();
	}

	/**
	 * @inheritDoc
	 */
	public static function supportsClassAdditionalId() {
		return static::getClassAdditionalIdName() !== null;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName() {
		return null;
	}

	/**
	 * @return int|string|null
	 */
	public function getTag() {
		return $this->tag;
	}

	/**
	 * @return Cryptocurrency
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork() {
		return $this->cryptocurrencyNetwork;
	}

	/**
	 * @return string
	 */
	public function serialize() {
		return $this->address . ($this->tag === null ? '' : ('#' . $this->tag));
	}

	/**
	 * @param string $address
	 * @param int|null $tag
	 * @return string
	 */
	public static function serializeAddress($address, $tag = null) {
		return $address . ($tag === null ? '' : ('#' . $tag));
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->tag === $address->tag;
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$addressParts = explode('#', $string);
		return new static($addressParts[0], $cryptocurrency, $cryptocurrencyNetwork, isset($addressParts[1]) ? (int)$addressParts[1] : null);
	}

	/**
	 * @param string $address
	 * @param $tag
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address, $tag = null) {
		return $this->createValidator($address, $tag)->validateWithExceptions();
	}

	/**
	 * @param $address
	 * @param null $tag
	 * @return Bech32AddressValidator
	 */
	protected abstract function createValidator($address, $tag = null);

}
