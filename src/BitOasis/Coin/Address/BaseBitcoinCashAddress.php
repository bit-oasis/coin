<?php

namespace BitOasis\Coin\Address;

use BitOasis\Coin\Cryptocurrency;
use BitOasis\Coin\CryptocurrencyAddress;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Address\Validators\BitcoinCash\AddressValidator;
use BitOasis\Coin\Address\Validators\BitcoinCash\BaseBitcoinCashAddressValidator;
use BitOasis\Coin\Utils\Strings;
use BitOasis\Coin\Utils\Base58Check\Base58Check;
use CashAddr\CashAddress;
use CashAddr\Exception\CashAddressException;
use CashAddr\Exception\Base32Exception;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
abstract class BaseBitcoinCashAddress implements CryptocurrencyAddress {

	/** @var string */
	protected $address;

	/** @var Cryptocurrency */
	protected $currency;

	/** @var AddressValidator */
	protected $validator;

	/** @var array */
	protected $cashAddressToBase58Prefixes = [
		'pubkeyhash' => 0x00,
		'scripthash' => 0x05,
	];

	/**
	 * BitcoinCashAddress constructor.
	 * @param string $address
	 * @param Cryptocurrency $currency
	 * @param bool $cashAddressAllowed
	 * @throws InvalidAddressException
	 */
	public function __construct($address, Cryptocurrency $currency, $cashAddressAllowed = true) {
		$this->validateAddress($address, $cashAddressAllowed);
		$this->address = $address;
		$this->currency = $currency;
		$this->validator = $this->createValidator($address);
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
	public function toBase58() {
		if ($this->validator->isBase58Address()) {
			return $this;
		}
		
		try {
			list($prefix, $scriptType, $binaryHash) = CashAddress::decode($this->toFullAddressString());
			if ($prefix !== BaseBitcoinCashAddressValidator::PREFIX_MAINNET) {
				throw new InvalidAddressPrefixException("Cannot convert CashAddress with prefix '$prefix'!");
			}
			if (!isset($this->cashAddressToBase58Prefixes[$scriptType])) {
				throw new InvalidAddressPrefixException("Cannot convert CashAddress version '$scriptType'!");
			}
			
			$base58BHash = Base58Check::encodeHash($binaryHash, Strings::convertDecimalToBinaryString($this->cashAddressToBase58Prefixes[$scriptType]));
			return new static($base58BHash, $this->currency, false);
		} catch (CashAddressException $e) {
			$this->throwInvalidAddressException($e);
		} catch (Base32Exception $e) {
			$this->throwInvalidAddressException($e);
		}
	}

	/**
	 * @return \static
	 * @throws InvalidAddressPrefixException
	 */
	public function toCashAddress() {
		if ($this->validator->isCashAddress()) {
			return $this;
		}
		
		$decodedAddress = Base58Check::decodeAddress($this->address);
		
		$version = $decodedAddress->getDecimalVersion();
		$hashVersion = array_search($version, $this->cashAddressToBase58Prefixes, true);
		if ($hashVersion === false) {
			throw new InvalidAddressPrefixException("Cannot convert base58 address with prefix '$version'!");
		}
		
		$cashAddress = CashAddress::encode(BaseBitcoinCashAddressValidator::PREFIX_MAINNET, $hashVersion, $decodedAddress->getHash());
		return new static($cashAddress, $this->currency);
	}

	/**
	 * Force prefix for CashAddress. If address is not CassAddress same as {@see toString}.
	 * @return string
	 */
	public function toFullAddressString() {
		$prefix = $this->getCashAddressPrefixWithSeparator();
		if ($this->validator->isCashAddress() && substr($this->address, 0, strlen($prefix)) !== $prefix) {
			return $prefix . $this->address;
		}
		
		return $this->toString();
	}

	/**
	 * Force CashAddress without prefix. If address is not CassAddress same as {@see toString}.
	 * @return string
	 */
	public function toShortAddressString() {
		$prefix = $this->getCashAddressPrefixWithSeparator();
		if ($this->validator->isCashAddress()) {
			return str_replace($prefix, '', $this->address);
		}
		
		return $this->toString();
	}

	/**
	 * @return string
	 */
	protected function getCashAddressPrefixWithSeparator() {
		return BaseBitcoinCashAddressValidator::PREFIX_MAINNET . BaseBitcoinCashAddressValidator::BASE32_SEPARATOR;
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 */
	private function isValid($address, $cashAddressAllowed = true) {
		return $this->crateValidator($address, $cashAddressAllowed)
			->validate();
	}

	/**
	 * @param $address
	 * @param bool $cashAddressAllowed
	 * @return bool
	 * @throws InvalidAddressException
	 */
	private function validateAddress($address, $cashAddressAllowed = true) {
		return $this->createValidator($address, $cashAddressAllowed)
			->validateWithExceptions();
	}

	/**
	 * @param \Exception $e
	 * @throws InvalidAddressException
	 */
	protected function throwInvalidAddressException(\Exception $e) {
		throw new InvalidAddressException($e->getMessage(), 0, $e);
	}

	/**
	 * @param string $address
	 * @param bool $cashAddressAllowed
	 * @return AddressValidator
	 */
	abstract protected function createValidator($address, $cashAddressAllowed = true);

}
