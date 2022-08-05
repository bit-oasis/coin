<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\StellarAddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\CryptocurrencyNetwork;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class StellarAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/** @var string|null */
	protected $memo;

	/**
	 * StellarAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param string|null $memo
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $memo = null) {
		$this->validateAddress($address, $memo);
		
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
		$this->memo = $memo;
	}

	public function toString() {
		return 'Address: ' . $this->address . ($this->memo === null ? '' : (', Memo: ' . $this->memo));
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
		return $this->getMemo();
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
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName() {
		return 'memo';
	}

	/**
	 * @return string|null
	 */
	public function getMemo() {
		return $this->memo;
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
		return $this->address . ($this->memo === null ? '' : ('#' . $this->memo));
	}

	/**
	 * @param CryptocurrencyAddress $address
	 * @return bool
	 */
	public function equals(CryptocurrencyAddress $address) {
		return $address instanceof static && $this->currency->equals($address->currency) && $this->address === $address->address && $this->memo === $address->memo;
	}

	/**
	 * @param string $address
	 * @param string|null $memo
	 * @return string
	 */
	public static function serializeAddress($address, $memo = null) {
		return $address . ($memo === null ? '' : ('#' . $memo));
	}

	/**
	 * @param $string
	 * @param Cryptocurrency $cryptocurrency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return StellarAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		$separatorPos = strpos($string, '#');
		if ($separatorPos === false) {
			$address = $string;
			$memo = null;
		} else {
			$address = substr($string, 0, $separatorPos);
			$memo = substr($string, $separatorPos + 1);
		}
		return new static($address, $cryptocurrency, $cryptocurrencyNetwork, $memo);
	}

	/**
	 * @param string $address
	 * @param $memo
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address, $memo = null) {
		$validator = new StellarAddressValidator($address, $memo);;
		$validator->validateWithExceptions();
	}

}
