<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Address\Validators\LitecoinBech32AddressValidator;
use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Address\Validators\LitecoinAddressValidator;
use BitOasis\Coin\MultiFormatAddress;
use BitOasis\Coin\CryptocurrencyNetwork;
use BitOasis\Coin\Utils\Base58Check\Base58Check;

/**
 * @author Daniel Robenek <daniel.robenek@me.com>
 */
class LitecoinAddress implements CryptocurrencyAddress, MultiFormatAddress {

	/** @var array */
	protected $legacyToNewAddressHexPrefix = [
		LitecoinAddressValidator::DEPRECATED_ADDRESS_VERSION => LitecoinAddressValidator::P2SH_ADDRESS_VERSION,
	];

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var CryptocurrencyNetwork */
	protected $cryptocurrencyNetwork;

	/** @var LitecoinAddressValidator */
	protected $validator;

	/** @var LitecoinBech32AddressValidator */
	protected $bech32Validator;

	/**
	 * BitcoinAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @param bool $oldFormatAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, CryptocurrencyNetwork $cryptocurrencyNetwork, $oldFormatAllowed = true) {
		$this->validator = new LitecoinAddressValidator($address);
		$this->bech32Validator = new LitecoinBech32AddressValidator($address);
		$this->validator->setDeprecatedAllowed($oldFormatAllowed);
		
		if(!$this->isValid()) {
			throw new InvalidAddressException('This is not valid litecoin address - ' . $address);
		}
		$this->address = $address;
		$this->currency = $currency;
		$this->cryptocurrencyNetwork = $cryptocurrencyNetwork;
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
	 * @return CryptocurrencyNetwork
	 */
	public function getNetwork() {
		return $this->cryptocurrencyNetwork;
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
	 * @param CryptocurrencyNetwork $cryptocurrencyNetwork
	 * @return CryptocurrencyAddress
	 * @throws InvalidAddressException
	 */
	public static function deserialize($string, Cryptocurrency $cryptocurrency, CryptocurrencyNetwork $cryptocurrencyNetwork) {
		return new static($string, $cryptocurrency, $cryptocurrencyNetwork);
	}

	/**
	 * @return static
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
			return new static(Base58Check::encodeAddress($decodedAddress), $this->currency, $this->cryptocurrencyNetwork, false);
		}
		
		return $this;
	}

	/**
	 * @return static
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
			return new static(Base58Check::encodeAddress($decodedAddress), $this->currency, $this->cryptocurrencyNetwork);
		}
		
		return $this;
	}

	/**
	 * @return bool
	 */
	private function isValid() {
		if ($this->validator->validate()) {
			return true;
		}

		if ($this->bech32Validator->validate()) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private function isBech32Address(): bool {
		// Bech32 always starts with ltc1
		return 0 === stripos($this->address, 'ltc1');
	}

	/**
	 * @inheritDoc
	 */
	public function getAddress() {
		if ($this->isBech32Address()) {
			return strtolower($this->address);
		}

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
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public static function getClassAdditionalIdName() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getOldFormatAddress() {
		$oldFormatAddress = $this->toLegacyAddressFormat()->address;
		$newFormatAddress = $this->toNewAddressFormat()->address;
		return $oldFormatAddress === $newFormatAddress ? null : $oldFormatAddress;
	}

	/**
	 * @inheritDoc
	 */
	public function getNewFormatAddress() {
		$oldFormatAddress = $this->toLegacyAddressFormat()->address;
		return $this->address === $oldFormatAddress ? $this->toNewAddressFormat()->address : $this->address;
	}

}
