<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Address\Validators\LitecoinAddressValidator;
use BitOasis\Coin\Utils\Base58Check\Base58Check;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddress implements CryptocurrencyAddress {

	/** @var array */
	protected $legacyToNewAddressHexPrefix = [
		LitecoinAddressValidator::DEPRECATED_ADDRESS_VERSION => LitecoinAddressValidator::P2SH_ADDRESS_VERSION,
	];

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var LitecoinAddressValidator */
	protected $validator;

	/**
	 * BitcoinAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $oldFormatAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $oldFormatAllowed = true) {
		$this->validator = new LitecoinAddressValidator($address);
		$this->validator->setDeprecatedAllowed($oldFormatAllowed);
		
		if(!$this->isValid()) {
			throw new InvalidAddressException('This is not valid litecoin address - ' . $address);
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
	 * @return \static
	 * @throws InvalidAddressPrefixException
	 */
	public function toNewAddressFormat() {
		if ($this->validator->isDeprecatedP2shAddress()) {
			$decodedAddress = Base58Check::decodeAddress($this->address);
			
			$version = $decodedAddress->getHexVersion();
			if (!isset($this->legacyToNewAddressHexPrefix[$version])) {
				throw new InvalidAddressPrefixException("Cannot convert address with prefix '$version'!");
			}
			
			$decodedAddress->setHexVersion($this->legacyToNewAddressHexPrefix[$version]);
			return new static(Base58Check::encodeAddress($decodedAddress), $this->currency, false);
		}
		
		return $this;
	}

	/**
	 * @return \static
	 * @throws InvalidAddressPrefixException
	 */
	public function toLegacyAddressFormat() {
		if ($this->validator->isP2shAddress()) {
			$decodedAddress = Base58Check::decodeAddress($this->address);
			
			$version = $decodedAddress->getHexVersion();
			$newVersion = array_search($version, $this->legacyToNewAddressHexPrefix, true);
			if ($newVersion === false) {
				throw new InvalidAddressPrefixException("Cannot convert address with prefix '$newVersion'!");
			}
			
			$decodedAddress->setHexVersion($newVersion);
			return new static(Base58Check::encodeAddress($decodedAddress), $this->currency);
		}
		
		return $this;
	}

	/**
	 * @return bool
	 */
	private function isValid() {
		return $this->validator->validate();
	}

}