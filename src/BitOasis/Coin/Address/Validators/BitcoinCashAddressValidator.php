<?php

namespace BitOasis\Coin\Address\Validators;

use CashAddr\Base32;
use CashAddr\CashAddress;
use CashAddr\Exception\CashAddressException;
use CashAddr\Exception\Base32Exception;
use Murich\PhpCryptocurrencyAddressValidation\Validation\BTC as BTCValidator;
use Murich\PhpCryptocurrencyAddressValidation\Validation\ValidationInterface;
use BitOasis\Coin\Exception\InvalidAddressException;
use BitOasis\Coin\Exception\InvalidAddressPrefixException;
use BitOasis\Coin\Exception\AddressMixedCaseException;

/**
 * @author David Fiedor <davefu@seznam.cz>
 */
class BitcoinCashAddressValidator implements ValidationInterface {

	const PREFIX_MAINNET = 'bitcoincash';
	const PREFIX_TESTNET = 'bchtest';
	const PREFIX_REGTEST = 'bchreg';
	const BASE32_SEPARATOR = Base32::SEPARATOR;

	/** @var string */
	protected $address;

	/** @var string */
	protected $expectedPrefix;

	/** @var BTCValidator - base58 validator */
	protected $btcValidator;

	/** @var bool */
	protected $cashAddressAllowed = true;

	/**
	 * @param string $address
	 * @param string $expectedPrefix
	 */
	public function __construct($address, $expectedPrefix = self::PREFIX_MAINNET) {
		$this->address = $address;
		$this->expectedPrefix = self::isPrefixValid($expectedPrefix) ? $expectedPrefix : self::PREFIX_MAINNET;
		$this->btcValidator = new BTCValidator($address);
	}

	/**
	 * @return boolean
	 */
	public function validate() {
		try {
			return $this->validateWithExceptions();
		} catch (InvalidAddressException $e) {
		}
		return false;
	}

	/**
	 * @return boolean only true or exception is thrown
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @throws AddressMixedCaseException
	 */
	public function validateWithExceptions() {
		if ($this->btcValidator->validate()) {
			return true;
		} else if (!$this->isCashAddressAllowed()) {
			$this->throwGeneralException();
		}
		
		if ($this->isCashAddressValid($this->address)) {
			return true;
		}
		
		$address = $this->fixPrefix($this->address);
		
		if ($this->isCashAddressValid($address)) {
			return true;
		}
		$this->throwGeneralException();
	}

	/**
	 * @param bool $cashAddressAllowed
	 */
	public function setCashAddressAllowed($cashAddressAllowed) {
		$this->cashAddressAllowed = $cashAddressAllowed;
	}

	/**
	 * @return bool
	 */
	public function isCashAddressAllowed() {
		return $this->cashAddressAllowed;
	}

	/**
	 * @return bool
	 */
	public function isBase58Address() {
		return $this->btcValidator->validate();
	}

	/**
	 * @return bool
	 */
	public function isCashAddress() {
		try {
			if (!$this->isBase58Address()) {
				$address = $this->fixPrefix($this->address);
				return $this->isCashAddressValid($address, false);
			}
		} catch (InvalidAddressException $e) {
		}
		
		return false;
	}

	/**
	 * @param $prefix
	 * @return bool
	 */
	protected static function isPrefixValid($prefix) {
		return in_array($prefix, [self::PREFIX_MAINNET, self::PREFIX_TESTNET, self::PREFIX_REGTEST], true);
	}

	/**
	 * @param string $address
	 * @param string $expectedPrefix
	 * @return string
	 * @throws InvalidAddressException
	 * @throws InvalidAddressPrefixException
	 * @throws AddressMixedCaseException
	 */
	protected function fixPrefix($address, $expectedPrefix = null) {
		$expectedPrefix = $expectedPrefix === null ? $this->expectedPrefix : $expectedPrefix;
		
		$prefix = $expectedPrefix . self::BASE32_SEPARATOR;
		$addressChunks = explode(self::BASE32_SEPARATOR, $this->address);
		$addressChunksCount = count($addressChunks);

		if ($addressChunksCount === 2) {
			if ($addressChunks[0] === $expectedPrefix) {
				//Correct full length address
				$address = $addressChunks[1];
			} else {
				//Full length address, but prefix does not match
				throw new InvalidAddressPrefixException('This is not valid bitcoin cash prefix - ' . $this->address);
			}
		} else if ($addressChunksCount !== 1) {
			//More than one separator (or something else => explode returns always at least one item)
			$this->throwGeneralException();
		}
		
		$lowercaseHash = mb_strtolower($address, 'UTF-8');
		if ($lowercaseHash !== $address && mb_strtoupper($address, 'UTF-8') !== $address) {
			throw new AddressMixedCaseException('Address has to be only lower or upper case - ' . $this->address);
		} else {
			//preferred style
			$address = $lowercaseHash;
		}
		
		return $prefix . $address;
	}

	/**
	 * @param string $address
	 * @param bool $validatePrefix
	 * @param string $expectedPrefix
	 * @return bool
	 */
	protected function isCashAddressValid($address, $validatePrefix = true, $expectedPrefix = null) {
		$expectedPrefix = $expectedPrefix === null ? $this->expectedPrefix : $expectedPrefix;
		
		try {
			$decodedAddress = CashAddress::decode($address);
			return $validatePrefix ? $decodedAddress[0] === $this->expectedPrefix : true;
		} catch (CashAddressException $e) {
		} catch (Base32Exception $e) {
		}
		
		return false;
	}

	/**
	 * @throws InvalidAddressException
	 */
	protected function throwGeneralException() {
		throw new InvalidAddressException('This is not valid bitcoin cash address - ' . $this->address);
	}

}
